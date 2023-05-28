const express = require('express');
const router = express.Router();
const {APP_NAME} = process.env

const orderPaymentHandler = require('./handler/orderPayment')


router.get('/', orderPaymentHandler.order);




module.exports = router;
