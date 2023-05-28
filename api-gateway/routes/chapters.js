const express = require('express');
const router = express.Router();


const chaptersHandler = require('./handler/chapters');

router.get('/:id', chaptersHandler.getById);
router.get('/', chaptersHandler.getAll);
router.post('/', chaptersHandler.create);
router.delete('/:id', chaptersHandler.deletes);
router.put('/:id', chaptersHandler.update);





module.exports = router;
