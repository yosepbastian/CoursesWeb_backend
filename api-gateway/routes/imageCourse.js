const express = require('express');
const router = express.Router();


const imageCourse = require('./handler/imagescourse');



router.post('/', imageCourse.create);
router.get('/', imageCourse.getAll);
router.get('/:id', imageCourse.getById);
router.delete('/:id', imageCourse.deletes);



module.exports = router;
