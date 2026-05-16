const mysql = require('mysql2/promise');
require('dotenv').config();

const pool = mysql.createPool({
    host: process.env.DB_HOST || 'localhost',
    user: process.env.DB_USER || 'root',
    password: process.env.DB_PASSWORD || 'password',
    database: process.env.DB_NAME || 'test_db',
    port: process.env.DB_PORT || 3306,
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0,
    charset: 'utf8mb4',
    timezone: 'local',
    enableKeepAlive: true,
    keepAliveInitialDelay: 10000
});

pool.getConnection()
    .then(conn => {
        console.log('[DB] Подключение к базе данных успешно');
        conn.release();
    })
    .catch(err => {
        console.error('[DB] Ошибка подключения к базе данных:', err.message);
        process.exit(1);
    });

module.exports = pool;
