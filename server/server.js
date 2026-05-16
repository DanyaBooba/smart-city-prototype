const http = require('http');
const express = require('express');
const { setupWebSocket } = require('./websocket');
const { startWatcher } = require('./services/watcher');

const app = express();
app.use(express.json());

require('./routes/index')(app);

const server = http.createServer(app);
setupWebSocket(server);

server.listen(9000, '127.0.0.1', () => {
    console.log('Сервер запущен на порту 9000');
    startWatcher();
});
