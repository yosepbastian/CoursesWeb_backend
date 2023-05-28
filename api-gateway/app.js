require('dotenv').config();

const express = require('express');
const path = require('path');
const cookieParser = require('cookie-parser');
const logger = require('morgan');

const indexRouter = require('./routes/index');
const usersRouter = require('./routes/users');
const coursesRouter = require('./routes/course');
const mediaRouter = require('./routes/media');
const verifyTokenRouter = require('./middleware/verifyToken');
const refreshTokenRouter = require('./routes/refresh_token');
const mentorRouter = require('./routes/mentors');
const chaptersRouter = require('./routes/chapters');
const lessonsRouter = require('./routes/lessons');
const imageCourseRouter = require('./routes/imageCourse');
const myCourseRouter = require('./routes/mycourses');
const reviewsRouter= require('./routes/reviews');
const webHookRouter = require('./routes/webhook');
const orderPaymentRouter = require('./routes/orderPayment');
const { Verify } = require('crypto');




const app = express();

app.use(logger('dev'));
app.use(express.json({ limit: '50mb' }));
app.use(express.urlencoded({ extended: false, limit: '50mb' }));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', indexRouter);
app.use('/users', usersRouter); 
app.use('/chapters',verifyTokenRouter, chaptersRouter);
app.use('/courses',verifyTokenRouter, coursesRouter);
app.use('/lessons',verifyTokenRouter, lessonsRouter);
app.use('/media', mediaRouter);
app.use('/refresh-token', refreshTokenRouter)
app.use('/mentors',verifyTokenRouter, mentorRouter);
app.use('/image-course',verifyTokenRouter,imageCourseRouter);
app.use('/my-course',verifyTokenRouter, myCourseRouter);
app.use('/reviews',verifyTokenRouter, reviewsRouter);
app.use('/webhook', webHookRouter);
app.use('/orders',verifyTokenRouter, orderPaymentRouter)

module.exports = app;
