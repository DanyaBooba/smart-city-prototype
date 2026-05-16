const postRoutes = require('./posts');

const { cors } = require('../middlewares/cors');
const { nocache } = require('../middlewares/nocache');
const { notfound } = require('../middlewares/notfound');

module.exports = (app) => {
    app.use(cors);
    app.use(nocache);

    app.use('/api', postRoutes);

    app.use(notfound);
};
