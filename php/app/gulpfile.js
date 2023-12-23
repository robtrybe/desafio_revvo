const { series, src, dest } = require('gulp');

function test(cb) {
    console.log('Gulp Rodando...')
    cb()
}

module.exports.default = series(test)