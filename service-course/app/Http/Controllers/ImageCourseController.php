<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageCourse;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class ImageCourseController extends Controller
{
    
    public function deleteById($id){
        $image = ImageCourse::find($id);

        if (!$image){
            return response()->json([
                'status' => 'error',
                'message' => 'Image course not found'
            ], 404);
        }

        $image->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Image Course deleted'
        ],200);
    }
    
    public function getAll(Request $request){
       
        $images = ImageCourse::query();
        $courseId = $request->query('course_id');

        $images->when($courseId, function($query) use ($courseId) {
            return $query->where('course_id', '=', $courseId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $images->get()
        ]);
    }

    public function getById($id){
    $image = ImageCourse::find($id);

    if(!$image){
        return response()->json([
            'status' => 'error',
            'message' => 'image not found'
        ],404);
    }

    return response()->json([
        'status' => 'succes',
        'message' => $image
    ],200);
    }

    public function create(Request $request){
        $rules = [
            'image' => 'required|url',
            'course_id' => 'required|integer'
        ];
    
        $data = $request->all();
        $validator = Validator::make($data, $rules);
    
        if($validator -> fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }
    
        $courseId = $request->input('course_id');
        $course = Course::find($courseId);
    
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ],404);
        }
        $image = ImageCourse::create($data);
        return response()->json([
            'status' => 'succes',
            'message' => $image
        ],200);
    }

    
}
