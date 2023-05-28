const express = require('express');
const router = express.Router();
const isBase64 = require('is-base64');
const base64Img = require('base64-img');
const fs = require('fs');
const path = require('path');

const { Media } = require('../models');

const { HOSTNAME } = process.env;

router.get('/', async(req, res) => {
  const media = await Media.findAll({
    attributes: ['id', 'image']
  });

  const mappedMedia = media.map((m) => {
    m.image = `${HOSTNAME}/${m.image.replace(/\\/g, '/')}`;
    return m;
  })

  return res.json({
    status: 'success',
    data: mappedMedia
  });
});

router.post('/', (req, res) => {
  const images = req.body.image;

  if (!isBase64(images, { mimeRequired: true })) {
    return res.status(400).json({ status: 'error', message: 'invalid base64' });
  }

  base64Img.img(images, './public/images', Date.now(), async (err, filepath) => {
    if (err) {
      return res.status(400).json({ status: 'error', message: err.message });
    }

    const filename = filepath.split('/').pop();

    const media = await Media.create({ image: `${filename}` });

    return res.json({
      status: 'success',
      data: {
        id: media.id,
        image: `${HOSTNAME}/${filename.replace(/\\/g, '/')}`
      }
    });

  })
});



router.delete('/:id', async (req, res) => {
  const id  = req.params.id;

  const media = await Media.findByPk(id);

  if (!media) {
    return res.status(404).json({ status: 'error', message: 'media not found'});
  }

  fs.unlink(`./${media.image}`, async (err) => {
    if (err) {
      return res.status(400).json({ status: 'error', message: err.message });
    }

    await media.destroy();

    return res.json({
      status: 'success',
      message: 'image deleted'
    });
  });
});


module.exports = router;
