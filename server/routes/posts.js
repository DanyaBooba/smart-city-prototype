const express = require('express');
const router = express.Router();
const PostController = require('../controllers/posts/post');

router.get('/post', PostController.get);
router.get('/posts/count', PostController.count);
router.get('/posts', PostController.getAll);

module.exports = router;
