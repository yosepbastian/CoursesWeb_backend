const express = require('express');
const router = express.Router();
const {APP_NAME} = process.env

const usersHandler = require('./handler/users')
const verifyToken= require('../middleware/verifyToken');

router.post('/register', usersHandler.register);
router.post('/login', usersHandler.login);
router.post('/logOut',verifyToken, usersHandler.logOut);
router.put('/',verifyToken, usersHandler.update,);
router.get('/',verifyToken, usersHandler.getUser,);


module.exports = router;
