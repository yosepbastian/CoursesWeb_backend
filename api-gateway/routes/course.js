const express = require('express');
const router = express.Router();


const courseHandler = require('./handler/courses');



router.get('/', courseHandler.getAll);
router.post('/', courseHandler.create);
router.put('/:id', courseHandler.update);
router.delete('/:id', courseHandler.deletes);
router.get('/:id', courseHandler.getById);


module.exports = router;
