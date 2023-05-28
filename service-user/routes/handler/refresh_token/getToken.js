const { RefreshToken } = require('../../../models');
const Validator = require('fastest-validator');
const v = new Validator();

module.exports = async (req, res) => {
const refreshToken = req.query.refresh_token;

const token = await RefreshToken.findOne({
where: { token:refreshToken }
}); 

if (!token){
    res.status(400).json({
        status: 'error',
        message: 'invalid token'
    })
}
res.json({
    status: 'succes',
    message: token
})
} 