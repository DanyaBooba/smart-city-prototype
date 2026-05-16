const fs = require('fs');
const PostModel = require('../models/posts/post');
const { broadcast } = require('../websocket');

/**
 * Читает JSON-файл выгрузки из 1С, парсит и записывает в БД.
 *
 * Структура файла:
 * {
 *   "ДатаВыгрузки": "17.02.2026 19:13:06",
 *   "ВсегоОбъявлений": 2,
 *   "Объявления": [
 *     {
 *       "Заголовок": "...",
 *       "Текст": "...",
 *       "Автор": "...",
 *       "Получатели": "...",
 *       "Важно": false,
 *       "ДатаПубликации": "13.02.2026 0:00:00",
 *       "КоличествоФайлов": 1,
 *       "Файлы": [{ "Имя": "...", "Размер": 1024, "Расширение": "...", "Содержимое": "base64..." }]
 *     }
 *   ]
 * }
 *
 * @param {string} filePath
 */
async function importFromFile(filePath) {
    const raw = fs.readFileSync(filePath, 'utf8').replace(/^\uFEFF/, '');
    const data = JSON.parse(raw);

    if (!data['ДатаВыгрузки'] || !Array.isArray(data['Объявления'])) {
        throw new Error('Файл не является выгрузкой объявлений из 1С');
    }

    const announcements = data['Объявления'];

    if (announcements.length === 0) {
        console.log('[importer] Объявлений в файле нет, пропускаем');
        return;
    }

    console.log(`[importer] Найдено объявлений: ${announcements.length}`);

    for (const item of announcements) {
        const post = {
            title: item['Заголовок'] || '',
            content: item['Текст'] || '',
            author: item['Автор'] || '',
            recipient: item['Получатели'] || '',
            important: item['Важно'] ? 1 : 0,
            created_at: parseDate(item['ДатаПубликации']),
        };

        const attachments = (item['Файлы'] || []).map(f => ({
            name: f['Имя'] || '',
            size: f['Размер'] || 0,
            format: f['Расширение'] || '',
            content: f['Содержимое'] || '',
        }));

        const postId = await PostModel.create(post, attachments);
        console.log(`[importer] Записано объявление id=${postId}: "${post.title}"`);

        const savedPost = await PostModel.find(postId);
        broadcast({ type: 'new_post', post: savedPost });
    }

    console.log(`[importer] Импорт завершён: ${filePath}`);

    // Удаляем файл после успешной обработки
    fs.unlinkSync(filePath);
    console.log(`[importer] Файл удалён: ${filePath}`);
}

/**
 * Парсит дату формата "13.02.2026 0:00:00" в объект Date.
 *
 * @param {string} str
 * @returns {Date}
 */
function parseDate(str) {
    if (!str) return new Date();

    // "13.02.2026 0:00:00" → "2026-02-13 00:00:00"
    const [datePart, timePart = '00:00:00'] = str.split(' ');
    const [day, month, year] = datePart.split('.');
    return new Date(`${year}-${month}-${day} ${timePart}`);
}

module.exports = { importFromFile };
