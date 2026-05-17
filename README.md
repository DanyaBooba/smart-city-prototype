# Прототип цифровой модели стенда умного города

Автор: Борисов Степан

Научный руководитель: Дыбка Даниил Викторович, daniil@dybka.ru

Дата начала: 1 мая 2026 г.

## Архитектура

`stand.izoserver.ru`

- `server/` — Node.js-приложение приема и отдачи данных по MQTT и HTTP+WebSocket соответственно
- `web/` — веб-ориентированная WebVR-локация
- `client/` — MQTT-клиент на стороне Изобретариума (примеры в `mqtt/`)

### Инструкция

**server**

```
# Перейти в папку server
cd server

# Скопировать .env.example и переименовать в .env
cp .env.example .env

# Настроить .env
nano .env

# Запустить сервер
node server
```

**client**

Без изменений копируется на `stand.izoserver.ru`

**client**

Запустите Raspberry Pi 4 и выполните следующие инструкции в терминале:

```
# Установка зависимостей
pip install paho-mqtt requests

# Для автоматического запуска скрипта
sudo nano /etc/systemd/system/energo.service

# Вносим в файл
[Unit]
Description=Energo MQTT Sync
After=network.target

[Service]
ExecStart=/usr/bin/python3 /home/pi/energo/main.py
Restart=always

[Install]
WantedBy=multi-user.target

# Активируем
sudo systemctl enable energo
sudo systemctl start energo
```
