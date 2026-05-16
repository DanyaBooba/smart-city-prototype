const chokidar = require('chokidar');
const fs = require('fs');
const path = require('path');
const { importFromFile } = require('./importer');
const { logFile } = require('./logger');
require('dotenv').config();

const WATCH_DIR = process.env.WATCH_DIR || '/home/upload/incoming';

async function processFile(filePath) {
    const fileName = path.basename(filePath);
    console.log(`[watcher] Обработка файла: ${filePath}`);
    try {
        await importFromFile(filePath);
        logFile(fileName, 'обработан');
    } catch (err) {
        console.error(`[watcher] Ошибка при обработке файла ${filePath}:`, err.message);
        logFile(fileName, `ошибка: ${err.message}`);
    }
}

async function processExisting() {
    let files;
    try {
        files = fs.readdirSync(WATCH_DIR);
    } catch {
        return;
    }

    const jsonFiles = files.filter(f => path.extname(f) === '.json');
    if (jsonFiles.length === 0) return;

    console.log(`[watcher] Найдено файлов при старте: ${jsonFiles.length}`);
    for (const file of jsonFiles) {
        await processFile(path.join(WATCH_DIR, file));
    }
}

function startWatcher() {
    const watcher = chokidar.watch(WATCH_DIR, {
        persistent: true,
        ignoreInitial: true,
        awaitWriteFinish: {
            stabilityThreshold: 500,
            pollInterval: 100,
        },
    });

    watcher.on('add', async (filePath) => {
        if (path.extname(filePath) !== '.json') return;
        await processFile(filePath);
    });

    watcher.on('error', (err) => {
        console.error('[watcher] Ошибка:', err.message);
    });

    console.log(`[watcher] Слежение за папкой: ${WATCH_DIR}`);

    processExisting();
}

module.exports = { startWatcher };
