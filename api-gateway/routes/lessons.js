const express = require('express');
const router = express.Router();


const lessonsHandler = require('./handler/lessons');

router.get('/:id', lessonsHandler.getById);
router.get('/', lessonsHandler.getAll);
router.post('/', lessonsHandler.create);
router.delete('/:id', lessonsHandler.deletes);
router.put('/:id', lessonsHandler.update);





module.exports = router;
