import paho.mqtt.client as mqtt
import requests
import json
from datetime import datetime

MQTT_USER = "daniil"
MQTT_PASS = "12345678990"
BROKER = '91.229.10.143'
PORT = 1883
LAN_URL = 'http://10.71.0.93:8004/JSONGreenCity/'

# Подключаемся к MQTT
client = mqtt.Client()
client.username_pw_set(MQTT_USER, MQTT_PASS)
client.connect(BROKER, PORT)
client.loop_start()


def publish(topic, data):
    """Публикуем данные в топик"""
    client.publish(
        f'energo/{topic}',
        json.dumps(data),
        qos=1,
        retain=True  # последнее значение сохранится для новых подписчиков
    )


def getbuild(node):
    """Извлекаем нужные поля из узла"""
    return {
        'id': node['ID'],
        'is_on': node['IsON'],
        'generated_power': node['GeneratedPower'],
        'required_power': node['RequiredPower'],
        'power': node['Power'],
    }


def publish_node(node, path):
    """Рекурсивно публикуем узел и всех его детей"""
    publish(path, getbuild(node))

    if node.get('Childs'):
        for child in node['Childs']:
            if child is not None:
                child_path = f"{path}/{child['ID']}"
                publish_node(child, child_path)


def sync():
    try:
        response = requests.get(LAN_URL, timeout=3)
        j = response.json()
    except Exception as e:
        print(f"Ошибка получения JSON: {e}")
        return 0

    # Общая информация
    publish('info', {
        'elements': j['ElementsOK'],
        'tree': j['TreeOK'],
        'generated_power': j['RootNode']['GeneratedPower'],
        'required_power': j['RootNode']['RequiredPower'],
        'lamp1': j['Lamp1val'],
        'lamp2': j['Lamp2val'],
        'wind': j['Windval'],
    })

    # Линии — рекурсивно
    for line in j['RootNode']['Lines']:
        if line is not None:
            publish_node(line, f"lines/{line['ID']}")

    # Станции
    for station in j['RootNode']['Stations']:
        if station is not None:
            publish_node(station, f"stations/{station['ID']}")

    return 1
