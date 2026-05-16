const fs = require('fs');
const path = require('path');
require('dotenv').config();

const LOG_DIR = process.env.LOG_DIR || '/var/log/pstgu';

fs.mkdirSync(LOG_DIR, { recursive: true });

function writeLog(filename, message) {
    const ts = new Date().toISOString().replace('T', ' ').slice(0, 19);
    const line = `[${ts}] ${message}\n`;
    try {
        fs.appendFileSync(path.join(LOG_DIR, filename), line, 'utf8');
    } catch (err) {
        console.error(`[logger] Не удалось записать в ${filename}: ${err.message}`);
    }
}

function logFile(fileName, status) {
    writeLog('files.log', `${fileName} | ${status}`);
}

function logWs(event) {
    writeLog('websocket.log', event);
}

module.exports = { logFile, logWs };
