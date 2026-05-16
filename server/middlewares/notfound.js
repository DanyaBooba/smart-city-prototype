const notfound = (req, res) => (
    res.status(404).json({
        status: false,
        error: 'Не найдено',
    })
)

module.exports = { notfound };
