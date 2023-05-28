const register = require('./register');
const login = require('./login');
const update = require('./update');
const getUser = require('./get_user')
const getAllUser = require('./get_all_users')
const logOut = require('./logout');

module.exports = {
    register,
    login,
    update,
    getUser,
    getAllUser,
    logOut
}