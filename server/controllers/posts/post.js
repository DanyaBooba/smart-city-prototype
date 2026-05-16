const PostModel = require('../../models/posts/post');

const PostController = {
    async get(req, res) {
        const { id } = req.query;

        if (!id) {
            return res.status(400).json({ message: 'id обязателен' });
        }

        const post = await PostModel.find(Number(id));

        if (!post) {
            return res.status(404).json({ message: 'Пост не найден' });
        }

        res.json(post);
    },

    async count(req, res) {
        const total = await PostModel.count();
        res.json({ total });
    },

    async getAll(req, res) {
        const { limit, offset } = req.query;
        const posts = await PostModel.getAll({
            limit: limit !== undefined ? Number(limit) : undefined,
            offset: offset !== undefined ? Number(offset) : undefined,
        });
        res.json(posts);
    }
};

module.exports = PostController;
