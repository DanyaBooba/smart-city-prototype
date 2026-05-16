const WebSocket = require('ws');
const { logWs } = require('./services/logger');

let wss = null;

function setupWebSocket(server) {
    wss = new WebSocket.Server({ server });

    wss.on('connection', (ws, req) => {
        const ip = req.socket.remoteAddress || 'unknown';
        console.log(`[INFO] Новый клиент подключился: ${ip}`);
        logWs(`подключение | ${ip}`);

        ws.on('close', () => {
            console.log(`[INFO] Клиент отключился: ${ip}`);
            logWs(`отключение | ${ip}`);
        });

        ws.on('error', (err) => {
            console.error(`[ERROR] ${err.message}`);
            logWs(`ошибка | ${ip} | ${err.message}`);
        });
    });

    console.log('[INFO] WebSocket инициализирован');
    return wss;
}

function broadcast(data) {
    if (!wss) return;

    const message = JSON.stringify(data);

    wss.clients.forEach((client) => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(message);
        }
    });
}

module.exports = { setupWebSocket, broadcast };
