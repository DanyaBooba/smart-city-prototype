const pool = require('../../config/database');

class PostModel {
    static get DEFAULT_FIELDS() {
        return [
            'id',
            'title',
            'content',
            'author',
            'recipient',
            'important',
            'created_at',
        ];
    }

    /**
     * Возвращает все посты с вложениями.
     *
     * @returns {Promise<Object[]>}
     */
    static async count() {
        const [[{ total }]] = await pool.query('SELECT COUNT(*) AS total FROM posts');
        return Number(total);
    }

    static async getAll({ limit, offset } = {}) {
        let sql = `SELECT ${this._fieldsToSelect()} FROM posts ORDER BY id DESC`;
        const params = [];

        if (limit !== undefined) {
            sql += ' LIMIT ?';
            params.push(Number(limit));
            if (offset !== undefined) {
                sql += ' OFFSET ?';
                params.push(Number(offset));
            }
        }

        const [posts] = await pool.query(sql, params);
        return this._attachToMany(posts);
    }

    /**
     * Ищет пост по ID и возвращает его вместе с вложениями.
     *
     * @param {number} id
     * @returns {Promise<Object|null>}
     */
    static async find(id) {
        const [rows] = await pool.query(
            `SELECT ${this._fieldsToSelect()} FROM posts WHERE id = ? LIMIT 1`,
            [id]
        );

        const post = rows[0] || null;
        if (!post) return null;

        post.attachments = await this._findAttachments(post.id);
        return post;
    }

    /**
     * Создаёт пост и его вложения в одной транзакции.
     * Если вставка вложений упадёт — пост тоже откатится.
     *
     * @param {Object} post
     * @param {string}  post.title
     * @param {string}  post.content
     * @param {string}  post.author
     * @param {string}  post.recipient
     * @param {number}  post.important
     * @param {Date}    post.created_at
     *
     * @param {Object[]} attachments
     * @param {string}   attachments[].name
     * @param {number}   attachments[].size
     * @param {string}   attachments[].content  base64
     *
     * @returns {Promise<number>} ID созданного поста
     */
    static async create(post, attachments = []) {
        const conn = await pool.getConnection();

        try {
            await conn.beginTransaction();

            const [postResult] = await conn.query(
                `INSERT INTO posts (title, content, author, recipient, important, created_at)
                 VALUES (?, ?, ?, ?, ?, ?)`,
                [
                    post.title,
                    post.content,
                    post.author,
                    post.recipient,
                    post.important,
                    post.created_at,
                ]
            );

            const postId = postResult.insertId;

            if (attachments.length > 0) {
                const rows = attachments.map(a => [
                    postId,
                    a.name,
                    a.format,
                    a.size,
                    a.content,
                    new Date(),
                ]);

                await conn.query(
                    `INSERT INTO attachments (post_id, name, format, size, content, created_at)
                     VALUES ?`,
                    [rows]
                );
            }

            await conn.commit();
            return postId;
        } catch (err) {
            await conn.rollback();
            throw err;
        } finally {
            conn.release();
        }
    }

    // ─── Закомментировано — будет использоваться позже ────────────────────────

    // static async update(id, { title, content, author, recipient, important }) {
    //     const [result] = await pool.query(
    //         `UPDATE posts SET title = ?, content = ?, author = ?, recipient = ?, important = ?
    //          WHERE id = ?`,
    //         [title, content, author, recipient, important, id]
    //     );
    //     return result;
    // }

    // static async delete(id) {
    //     const [result] = await pool.query(
    //         `DELETE FROM posts WHERE id = ?`,
    //         [id]
    //     );
    //     return result.affectedRows > 0;
    // }

    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Возвращает вложения для одного поста.
     *
     * @param {number} postId
     * @returns {Promise<Object[]>}
     */
    static async _findAttachments(postId) {
        const [rows] = await pool.query(
            `SELECT id, post_id, name, format, size, content, created_at
             FROM attachments
             WHERE post_id = ?
             ORDER BY created_at ASC`,
            [postId]
        );
        return rows;
    }

    /**
     * Подгружает вложения для массива постов одним запросом.
     *
     * @param {Object[]} posts
     * @returns {Promise<Object[]>}
     */
    static async _attachToMany(posts) {
        if (posts.length === 0) return [];

        const ids = posts.map(p => p.id);
        const placeholders = ids.map(() => '?').join(', ');

        const [attachments] = await pool.query(
            `SELECT id, post_id, name, format, size, content, created_at
             FROM attachments
             WHERE post_id IN (${placeholders})
             ORDER BY created_at ASC`,
            ids
        );

        const attachMap = {};
        for (const att of attachments) {
            if (!attachMap[att.post_id]) attachMap[att.post_id] = [];
            attachMap[att.post_id].push(att);
        }

        return posts.map(post => ({
            ...post,
            attachments: attachMap[post.id] || [],
        }));
    }

    /** @private */
    static _fieldsToSelect() {
        return this.DEFAULT_FIELDS.join(', ');
    }
}

module.exports = PostModel;
