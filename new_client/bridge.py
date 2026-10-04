# =====================================================================
#  bridge.py — мост «IoT-устройство -> MQTT -> WebVR»
#
#  Каждые 3 секунды:
#    1. забираем JSON с устройства по HTTP (локальная сеть);
#    2. отправляем каждый узел дерева в свой MQTT-топик.
#
#  Установка библиотек:
#    pip install paho-mqtt requests
#
#  Запуск (пароль не храним в коде, передаём при запуске):
#    MQTT_PASS=секрет python3 bridge.py
# =====================================================================

import json
import os
import time
from datetime import datetime

import paho.mqtt.client as mqtt
import requests

# ---------------- Настройки ----------------
BROKER = "91.229.10.143"
PORT = 1883
MQTT_USER = "daniil"
MQTT_PASS = os.environ.get("MQTT_PASS", "")   # пароль из переменной окружения
LAN_URL = "http://10.71.0.93:8004/JSONGreenCity/"
PERIOD = 3          # раз во сколько секунд опрашиваем устройство
RESEND_EVERY = 100  # раз во столько циклов отправляем всё заново, даже без изменений


# ---------------- Подключение к MQTT ----------------

# В новых версиях paho (2.x) нужно указать версию API, в старых — нет.
# Этот блок работает с обеими.
try:
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2)
except AttributeError:
    client = mqtt.Client()

client.username_pw_set(MQTT_USER, MQTT_PASS)

# «Последняя воля»: если мост пропадёт, брокер сам напишет "offline".
# Так WebVR узнает, что стенд отключился.
client.will_set("energo/bridge", "offline", qos=1, retain=True)

# Если связи нет, не копим сообщения бесконечно (иначе кончится память)
client.max_queued_messages_set(200)

# Пытаемся подключиться, пока не получится
while True:
    try:
        client.connect(BROKER, PORT)
        break
    except Exception as e:
        print(f"Брокер недоступен ({e}), пробую снова через 5 секунд...")
        time.sleep(5)

client.loop_start()  # фоновый поток: отправляет сообщения и сам переподключается
client.publish("energo/bridge", "online", qos=1, retain=True)


# ---------------- Отправка данных ----------------

last_sent = {}  # что последний раз отправили в каждый топик


def publish(topic, data):
    """Отправляем данные в топик energo/<topic>, но только если они изменились."""
    full_topic = f"energo/{topic}"
    payload = json.dumps(data, ensure_ascii=False)

    if last_sent.get(full_topic) == payload:
        return  # ничего не поменялось, не шлём

    client.publish(full_topic, payload, qos=1, retain=True)
    last_sent[full_topic] = payload


def get_build(node):
    """Берём из узла только нужные поля."""
    return {
        "id": node["ID"],
        "is_on": node["IsON"],
        "generated_power": node["GeneratedPower"],
        "required_power": node["RequiredPower"],
        "power": node["Power"],
    }


def publish_node(node, path):
    """Отправляем узел, а потом (рекурсивно) всех его детей."""
    publish(path, get_build(node))

    children = node.get("Childs") or []  # у листьев Childs = null
    for child in children:
        if child is not None:
            publish_node(child, f"{path}/{child['ID']}")


def sync():
    """Один цикл: скачать JSON и всё отправить. Возвращает True, если всё хорошо."""
    try:
        response = requests.get(LAN_URL, timeout=3)
        # Берём сырые байты (.content), а не response.json():
        # так русские буквы точно прочитаются как UTF-8,
        # даже если устройство не указало кодировку в ответе
        j = json.loads(response.content)
        root = j["RootNode"]

        # Общая информация + время, чтобы WebVR видел, что данные свежие
        publish("info", {
            "elements": j["ElementsOK"],
            "tree": j["TreeOK"],
            "generated_power": root["GeneratedPower"],
            "required_power": root["RequiredPower"],
            "lamp1": j["Lamp1val"],
            "lamp2": j["Lamp2val"],
            "wind": j["Windval"],
            "ts": int(time.time()),
        })

        for line in root["Lines"]:
            if line is not None:
                publish_node(line, f"lines/{line['ID']}")

        for station in root["Stations"]:
            if station is not None:
                publish_node(station, f"stations/{station['ID']}")

        return True

    except Exception as e:
        # Любая ошибка (нет сети, битый JSON, нет поля) — пишем и идём дальше
        print(f"[{datetime.now():%H:%M:%S}] Ошибка: {e}")
        return False


# ---------------- Главный цикл ----------------

count = 0
errors = 0

while True:
    start = time.time()

    # Время от времени забываем, что отправляли, — тогда всё уйдёт заново
    if count % RESEND_EVERY == 0:
        last_sent.clear()

    if not sync():
        errors += 1
    count += 1

    # Пишем в консоль не каждый раз, а раз в 100 циклов (~5 минут),
    # чтобы не изнашивать SD-карту на Raspberry Pi
    if count % 100 == 0:
        print(f"[{datetime.now():%H:%M:%S}] Работаю: {count} циклов, ошибок {errors}")

    # Спим ровно столько, чтобы цикл был раз в PERIOD секунд
    time.sleep(max(0, PERIOD - (time.time() - start)))
