#include <Arduino.h>
#include <SoftwareSerial.h> //Included SoftwareSerial Library
#include <ESP8266WiFi.h>
#include <PubSubClient.h>

int  delayMS = 30000;  // Задаержка в мс между публикацией сообщений
long lastMsg = 0;      // Время публикации предыдущего сообщения  (мс) 
int  value = 0;        // Переменная для формирования публикуемого сообщения
String string_data="";


const char* ssid = "Izobretay_Luxury"; 
const char* password =  "SkazhiteI";

const char* mqtt_server = "185.255.132.193";
const char* mqtt_user = "admin";
const char* mqtt_password = "Gm2Iou2I5T4O";
const int mqtt_port = 1883;

WiFiClient espClient;
PubSubClient client(espClient);

SoftwareSerial s(5,16);
int counter = 0;
int if_write_to_stack=0;
String stack =  "";


void setup();
void MQTTcallback(char* topic, byte* payload, unsigned int length);
void loop();

void setup() 
{
 Serial.begin(9600);
 delay(3000);
 s.begin(9600);
 delay(3000);
 WiFi.begin(ssid, password);

 while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.println("Connecting to WiFi..");
  }

 Serial.print("Connected to WiFi :");
 Serial.println(WiFi.SSID());

 pinMode(2, OUTPUT);
 digitalWrite(2, HIGH);
 delay(1000);


  client.setServer(mqtt_server, mqtt_port);
  client.setCallback(MQTTcallback);
  while (!client.connected()) 
  {
    Serial.println("Connecting to MQTT...");
    if (client.connect("ESP8266", mqtt_user, mqtt_password))
    {
      Serial.println("connected");
    }
    else
    {
      Serial.print("failed with state ");
      Serial.println(client.state());
      delay(2000);
    }
  }
  client.subscribe("test");

}

void MQTTcallback(char* topic, byte* payload, unsigned int length) 
{
  Serial.print("Message received in topic: ");
  Serial.println(topic);
  Serial.print("Message:");
  String message;

  // тут формируем строку message из символов приходящих из топика topic (в нашем случае - это test)
  for (int i = 0; i < length; i++) 
  {
    message = message + (char)payload[i];
  }
  Serial.print(message);

  // Отправляем message в Arduino
  char Buf[50];
  message.toCharArray(Buf, 50);
  s.write(Buf); //именно тут мы пишем в прогаммный serial в сторону Arduino

  if (message == "on") 
  {
    digitalWrite(2, LOW);
    Serial.println("---> on");

    //String str = "123";
  }
  else if (message == "off") 
  {
    digitalWrite(2, HIGH);
    Serial.println("---> off");
  }
  Serial.println();
  Serial.println("-----------------------");
}


void loop() 
{


 // 1 Блок: Начало блока кода обмена данными с MQTT 
 //client.publish("test", "hello izob"); // отправка данных на MQTT
 client.loop(); //прием данных от MQTT
 // Конец блока кода обмена данными с MQTT

 // 2 Блок: отправка в Arduino
 if(Serial.available() > 0) 
   {
       String str = Serial.readString();  // как преобразовать String в char
       Serial.println(str);
       //str = "123";
       char Buf[50];
       str.toCharArray(Buf, 50);
       s.write(Buf);
  }


 // 3 Блок: прием от Arduino (с учетом управляющих команд {gori} и {potuhni}) 
 if(s.available()) 
   {
   char c = s.read();

   if(String(c)=="{")
     {
      if_write_to_stack=1;
     }

   if(String(c)=="}")
     {
      if_write_to_stack=0;
     }

   if(if_write_to_stack==1 and String(c)!="{")
     {
      // Serial.print("+:");
      stack = stack + String(c);
     }
   else
     {
      // Serial.print("-:");
      Serial.print("Stack closed:");
      Serial.println(stack);//финальная строка от Arduino
          if(stack=="gori")
        {
         Serial.println("!!!");
         digitalWrite(2, LOW);
         client.publish("test", "gori");  // на этом остановилтсь
        }
      if(stack=="potuhni")
        {
         Serial.println("!!!");
         digitalWrite(2, HIGH);
         client.publish("test", "potuhni");  // на этом остановилтсь
        }
      if(stack=="dva")
        {
         Serial.println("!!!");
         digitalWrite(2, HIGH);
         delay(1000);
         Serial.println("!!!");
         digitalWrite(2, LOW);
         delay(1000);
         Serial.println("!!!");
         digitalWrite(2, LOW);
         Serial.println("!!!");
         digitalWrite(2, HIGH);
         delay(1000);
         Serial.println("!!!");
         digitalWrite(2, LOW);
         delay(1000);
        }
        if(stack.startsWith("dist:")) {
          // Извлекаем числовое значение расстояния
          String distStr = stack.substring(5);  // убираем "dist:"
          float distance = distStr.toFloat();
      
          Serial.print("Distance received: ");
          Serial.println(distance);
      
          //  ПУБЛИКАЦИЯ В MQTT
          String topic = "test";
          String payload = String(distance, 1);  // 1 знак после запятой
          client.publish(topic.c_str(), payload.c_str());
      
          Serial.print("Published to ");
          Serial.print(topic);
          Serial.print(": ");
          Serial.println(payload);
    }
      stack = "";
      }
   Serial.println(String(c));
  }
}
