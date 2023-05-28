const jwt = require('jsonwebtoken');

const JWT_SECRET = 'bwamicro!23';

// create basic token dengan proses syncronus

const token = jwt.sign({ data: { kelas: 'bwamicro' }},JWT_SECRET, {expiresIn: '20m'});
console.log(token)

// //create basic token dengan proses asynchrounous

// jwt.sign({ data: { kelas: 'bwamicro' }},JWT_SECRET,(err,token)=> {
//     console.log(token)
// })

jwt.verify(token, JWT_SECRET, (err, decoded)=>{
    if (err){
        console.log(err.message)
        return;
    }
    console.log(decoded)
})