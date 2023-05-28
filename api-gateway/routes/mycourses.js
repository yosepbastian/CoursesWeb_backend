const express = require('express');
const router = express.Router();


const myCourses = require('./handler/mycourse')



router.post('/',myCourses.create);
router.get('/', myCourses.getAll);


    


module.exports = router;
