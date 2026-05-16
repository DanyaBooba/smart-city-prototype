//
// Доступы
//

const connection = {
    broker: '91.229.10.143',
    port: 9001,
    topic: 'daniil_dybka',
    qos: 0,
    clientId: `client_${Math.random() * 100}_${new Date().getTime()}`,
    user: {
        name: 'daniil',
        password: '12345678990'
    }
}

//
// Производим подключение
//

const client = new Paho.MQTT.Client(
    connection.broker,
    connection.port,
    connection.clientId
);

//
// При потере подключения
//

client.onConnectionLost = (responseObject) => {
    if (responseObject.errorCode !== 0) {
        console.log(`Соединение потеряно: ${responseObject.errorMessage}`);
        setTimeout(() => {
            connect();
        }, 3000);
    }
}

//
// При получении сообщения
//

client.onMessageArrived = (message) => {
    console.log(`Пришло сообщение: ${message.payloadString}`);
}

//
// При успешном подключении
//

console.log("Пытаемся подключиться...");
connect();

function connect() {
    client.connect({
        userName: connection.user.name,
        password: connection.user.password,
        onSuccess: () => {
            console.log("Подключение к MQTT брокеру успешно!");

            client.subscribe(
                connection.topic,
                {
                    qos: connection.qos,
                    timeout: 5,
                    onSuccess: () => {
                        onSuccess();
                    },
                    onFailure: (error) => {
                        console.log("Ошибка подключения: " + error.errorMessage);
                    }
                }
            );
        }
    });
}

//
// Отправка сообщения в топик
//

function sendMessage(text = 'Пример сообщения') {
    const message = new Paho.MQTT.Message(text);
    message.destinationName = connection.topic;
    client.send(message);
}

//
// После успешного подключения
//

function onSuccess() {
    console.log('Успех!');
    sendMessage();
}
