Подключение из Python (paho-mqtt)
Пример подписчика (получение сообщений):

python
import paho.mqtt.client as mqtt

BROKER = '185.255.132.193'   # IP вашего сервера
PORT = 1883
TOPIC = "test"
USERNAME = "admin"
PASSWORD = "ваш_пароль"
CLIENT_ID = "python-subscriber"

def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Connected to MQTT Broker!")
        client.subscribe(TOPIC)
    else:
        print(f"Failed to connect, return code {rc}")

def on_message(client, userdata, msg):
    print(f"Received {msg.payload.decode()} from {msg.topic} topic")

def run():
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2, CLIENT_ID)
    client.username_pw_set(USERNAME, PASSWORD)
    client.on_connect = on_connect
    client.on_message = on_message
    client.connect(BROKER, PORT)
    client.loop_forever()

if name == 'main':
    run()
Пример издателя (отправка сообщений):

python
import paho.mqtt.client as mqtt

BROKER = '185.255.132.193'
PORT = 1883
TOPIC = "test"
USERNAME = "admin"
PASSWORD = "ваш_пароль"
CLIENT_ID = "python-publisher"

def on_connect(client, userdata, flags, rc):
    if rc == 0:
        print("Connected to MQTT Broker!")
    else:
        print(f"Failed to connect, return code {rc}")

def run():
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2, CLIENT_ID)
    client.username_pw_set(USERNAME, PASSWORD)
    client.on_connect = on_connect
    client.connect(BROKER, PORT)
    client.loop_start()  # запускаем цикл в фоне

    while True:
        msg = input("Введите сообщение (или 'exit'): ")
        if msg.lower() == 'exit':
            break
        client.publish(TOPIC, msg)
        print("Сообщение отправлено")

    client.loop_stop()
    client.disconnect()

if name == 'main':
    run()
