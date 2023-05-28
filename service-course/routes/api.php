<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ImageCourseController;
use App\Http\Controllers\myCourseController;
use App\Http\Controllers\reviewController;


//mentor route
Route::post('mentors', [MentorController::class, 'create']);
Route::put('mentors/{id}', [MentorController::class, 'update']);
Route::get('mentors', [MentorController::class, 'getAll']);
Route::get('mentors/{id}', [MentorController::class, 'getById']);
Route::delete('mentors/{id}', [MentorController::class, 'deleteById']);


//course route
Route::post('courses', [CourseController::class, 'create']);
Route::get('courses', [CourseController::class, 'getAll']);
Route::get('courses/{id}', [CourseController::class, 'getById']);
Route::get('courses', [CourseController::class, 'index']);
Route::put('courses/{id}', [CourseController::class, 'GGGupdate']);
Route::delete('courses/{id}', [CourseController::class, 'deleteById']);


//Chapter Route
Route::post('chapters', [ChapterController::class, 'create']);
Route::put('chapters/{id}', [ChapterController::class, 'update']);
Route::get('chapters/{id}', [ChapterController::class, 'getById']);
Route::get('chapters', [ChapterController::class, 'getAll']);
Route::delete('chapters/{id}', [ChapterController::class, 'deleteById']);

//Lesson Route
Route::post('Lessons', [LessonController::class, 'create']);
Route::put('Lessons/{id}', [LessonController::class, 'update']);
Route::delete('Lessons/{id}', [LessonController::class, 'deleteById']);
Route::get('Lessons', [LessonController::class, 'getAll']);
Route::get('Lessons/{id}', [LessonController::class, 'getById']);

//ImageCourse Route
Route::post('Image-Course', [ImageCourseController::class, 'create']);
Route::get('Image-Course', [ImageCourseController::class, 'getAll']);
Route::get('Image-Course/{id}',[ImageCourseController::class, 'getById']);
Route::delete('Image-Course/{id}', [ImageCourseController::class, 'deleteById']);

//My Courses Route
Route::post('My-Course', [myCourseController::class, 'create']);
Route::get('My-Course', [myCourseController::class, 'index']);
Route::post('My-Course/premium', [myCourseController::class, 'createPremiumAcces']);

//Review Route
Route::post('Reviews', [reviewController::class, 'create']);
Route::delete('Reviews/{id}', [reviewController::class, 'deleteById']);
Route::put('Reviews/{id}', [reviewController::class, 'update']);