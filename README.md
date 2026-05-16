# Прототип цифровой модели стенда умного города

Автор: Борисов Степан

Научный руководитель: Дыбка Даниил Викторович, daniil@dybka.ru

Дата начала: 1 мая 2026 г.

## Архитектура

`stand.izoserver.ru`

- `server/` — Node.js-приложение приема и отдачи данных по MQTT и HTTP+WebSocket соответственно
- `web/` — веб-ориентированная WebVR-локация
- `client/` — MQTT-клиент на стороне Изобретариума

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

...
