const express = require('express');
const router = express.Router();
const {APP_NAME} = process.env

const webHookHandler = require('./handler/webhook')


router.post('/', webHookHandler.webHook);




module.exports = router;
