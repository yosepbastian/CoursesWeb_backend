const express = require('express');
const router = express.Router();
const refreshTokenHandler = require('./handler/refreshToken')



router.post('/', refreshTokenHandler.refreshToken);


module.exports = router;
