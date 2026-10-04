// =====================================================================
//  sync.cpp — мост «IoT-устройство → MQTT»
//
//  Что делает программа (каждые 3 секунды):
//    1. Скачивает JSON с устройства по HTTP (внутри локальной сети).
//    2. Разбирает JSON и отправляет каждый узел дерева в свой MQTT-топик.
//
//  Нужные библиотеки (Ubuntu/Debian):
//    sudo apt install g++ libcurl4-openssl-dev libmosquitto-dev nlohmann-json3-dev
//
//  Сборка:
//    g++ -std=c++17 -O2 sync.cpp -o sync -lcurl -lmosquitto
//
//  Запуск (логин и пароль НЕ пишем в код, а передаём через переменные окружения):
//    MQTT_USER=daniil MQTT_PASS=секрет ./sync
// =====================================================================

#include <chrono>    // время и паузы
#include <cstdlib>   // getenv — чтение переменных окружения
#include <ctime>     // текущее время для вывода в консоль
#include <iostream>  // cout / cerr — вывод в консоль
#include <string>
#include <thread>    // this_thread::sleep_until — пауза

#include <curl/curl.h>         // HTTP-запросы
#include <mosquitto.h>         // MQTT-клиент
#include <nlohmann/json.hpp>   // работа с JSON

// Короткое имя для типа JSON, чтобы не писать каждый раз длинное
using json = nlohmann::json;

// ---------------- Настройки ----------------
const char* BROKER  = "91.229.10.143";
const int   PORT    = 1883;
const char* LAN_URL = "http://10.71.0.93:8004/JSONGreenCity/";

// MQTT-клиент один на всю программу, поэтому делаем его глобальным
mosquitto* client = nullptr;


// ---------------- HTTP ----------------

// Эту функцию вызывает curl, когда приходит очередной кусочек ответа.
// Мы просто дописываем кусочек в конец строки buffer.
size_t on_data(char* ptr, size_t size, size_t nmemb, void* userdata) {
    std::string* buffer = static_cast<std::string*>(userdata);
    buffer->append(ptr, size * nmemb);
    return size * nmemb;  // сообщаем curl'у: «принял все байты»
}

// Скачивает страницу по адресу url и кладёт текст в out.
// Возвращает true, если всё получилось.
bool http_get(const std::string& url, std::string& out) {
    CURL* curl = curl_easy_init();
    if (!curl) return false;

    curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
    curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, on_data);  // куда складывать ответ
    curl_easy_setopt(curl, CURLOPT_WRITEDATA, &out);
    curl_easy_setopt(curl, CURLOPT_TIMEOUT, 3L);             // ждём не дольше 3 секунд

    CURLcode result = curl_easy_perform(curl);  // сам запрос

    long http_code = 0;
    curl_easy_getinfo(curl, CURLINFO_RESPONSE_CODE, &http_code);
    curl_easy_cleanup(curl);  // освобождаем память

    if (result != CURLE_OK) {
        std::cerr << "Ошибка получения JSON: " << curl_easy_strerror(result) << "\n";
        return false;
    }
    if (http_code != 200) {
        std::cerr << "Сервер ответил кодом " << http_code << "\n";
        return false;
    }
    return true;
}


// ---------------- MQTT ----------------

// Публикуем данные в топик energo/<topic>
void publish(const std::string& topic, const json& data) {
    std::string full_topic = "energo/" + topic;
    std::string payload    = data.dump();  // JSON -> строка

    int rc = mosquitto_publish(
        client,
        nullptr,                    // id сообщения нам не нужен
        full_topic.c_str(),
        (int)payload.size(),
        payload.c_str(),
        1,                          // QoS 1 — брокер подтвердит получение
        true                        // retain — последнее значение сохранится для новых подписчиков
    );

    if (rc != MOSQ_ERR_SUCCESS) {
        std::cerr << "Не удалось отправить " << full_topic << ": "
                  << mosquitto_strerror(rc) << "\n";
    }
}


// ---------------- Разбор дерева ----------------

// Берём из узла только нужные поля.
// .at("ID") вместо ["ID"]: если поля нет, будет понятная ошибка, а не падение.
json get_build(const json& node) {
    return {
        {"id",              node.at("ID")},
        {"is_on",           node.at("IsON")},
        {"generated_power", node.at("GeneratedPower")},
        {"required_power",  node.at("RequiredPower")},
        {"power",           node.at("Power")},
    };
}

// Рекурсивно публикуем узел и всех его детей.
// Рекурсия = функция вызывает саму себя для каждого ребёнка.
void publish_node(const json& node, const std::string& path) {
    publish(path, get_build(node));

    // У листьев дерева "Childs" равен null, у остальных — массив
    if (node.contains("Childs") && node.at("Childs").is_array()) {
        for (const json& child : node.at("Childs")) {
            if (child.is_null()) continue;  // пустые места пропускаем
            std::string child_path = path + "/" + child.at("ID").get<std::string>();
            publish_node(child, child_path);
        }
    }
}

// Один цикл: скачать JSON и всё опубликовать.
bool sync() {
    std::string body;
    if (!http_get(LAN_URL, body)) return false;

    try {
        json j = json::parse(body);           // строка -> JSON
        const json& root = j.at("RootNode");

        // Общая информация
        publish("info", {
            {"elements",        j.at("ElementsOK")},
            {"tree",            j.at("TreeOK")},
            {"generated_power", root.at("GeneratedPower")},
            {"required_power",  root.at("RequiredPower")},
            {"lamp1",           j.at("Lamp1val")},
            {"lamp2",           j.at("Lamp2val")},
            {"wind",            j.at("Windval")},
        });

        // Линии — рекурсивно
        for (const json& line : root.at("Lines")) {
            if (!line.is_null())
                publish_node(line, "lines/" + line.at("ID").get<std::string>());
        }

        // Станции
        for (const json& station : root.at("Stations")) {
            if (!station.is_null())
                publish_node(station, "stations/" + station.at("ID").get<std::string>());
        }
    } catch (const json::exception& e) {
        // Сюда попадём, если JSON битый или в нём нет нужного поля
        std::cerr << "Ошибка в JSON: " << e.what() << "\n";
        return false;
    }
    return true;
}

// Текущее время в виде "ЧЧ:ММ:СС"
std::string now_hms() {
    std::time_t t = std::time(nullptr);
    char buf[16];
    std::strftime(buf, sizeof(buf), "%H:%M:%S", std::localtime(&t));
    return buf;
}


// ---------------- main ----------------

int main() {
    // Логин и пароль берём из окружения, а не из кода
    const char* user = std::getenv("MQTT_USER");
    const char* pass = std::getenv("MQTT_PASS");
    if (!user || !pass) {
        std::cerr << "Задайте переменные окружения MQTT_USER и MQTT_PASS\n";
        return 1;
    }

    // Подготовка библиотек (делается один раз)
    curl_global_init(CURL_GLOBAL_DEFAULT);
    mosquitto_lib_init();

    // Создаём MQTT-клиента и подключаемся к брокеру
    client = mosquitto_new(nullptr, true, nullptr);
    mosquitto_username_pw_set(client, user, pass);

    // Если связь пропадёт, библиотека сама переподключится
    // (пауза между попытками от 1 до 30 секунд)
    mosquitto_reconnect_delay_set(client, 1, 30, true);

    int rc = mosquitto_connect(client, BROKER, PORT, 60);
    if (rc != MOSQ_ERR_SUCCESS) {
        std::cerr << "Не удалось подключиться к брокеру: " << mosquitto_strerror(rc) << "\n";
        return 1;
    }

    // Запускаем фоновый поток, который отправляет сообщения и держит связь
    mosquitto_loop_start(client);

    int count = 1;
    while (true) {
        // Запоминаем время начала, чтобы цикл был ровно раз в 3 секунды,
        // а не «3 секунды + время работы»
        auto start = std::chrono::steady_clock::now();

        bool ok = sync();
        std::cout << "[" << count << "] " << (ok ? "OK" : "ERROR")
                  << " (" << now_hms() << ")" << std::endl;
        count++;

        std::this_thread::sleep_until(start + std::chrono::seconds(3));
    }

    // Сюда программа не дойдёт (цикл бесконечный), но так правильно убирать за собой
    mosquitto_loop_stop(client, true);
    mosquitto_destroy(client);
    mosquitto_lib_cleanup();
    curl_global_cleanup();
    return 0;
}
