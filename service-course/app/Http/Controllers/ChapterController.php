<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ChapterController extends Controller  
{
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'course_id' => 'required|integer',

        ];
        $data = $request->all();
        $validator = Validator::make($data,$rules);
    
        if($validator->fails()){
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
        ], 404);
       }

       $chapter = Chapter::create($data);
       return response()->json([
        'status' => 'succes',
        'data' => $chapter
       ], 200);
}

public function update(Request $request, $id){
    $rules = [
        'name' => 'string',
        'course_id' => 'integer',
       
    ];

    $data = $request->all();

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 400);
    }
    $chapter = Chapter::find($id);

    if (!$chapter){
        return response()->json([
            'status'=> 'error',
            'message' => 'chapter not found'
        ],404);
    }

  
    // Mengambil chapter berdasarkan course_id
    $courseId = $request->input('course_id');
    
 
    // Memeriksa apakah course ditemukan
    if ($courseId) {
        $course = Course::find($courseId);
        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ], 404);
        }
    
       
    }

    $chapter->fill($data);
    $chapter->save();

    return response()->json([
        'status'=>'success',
        'data'=> $chapter
    ],200);
    }


    public function getById($id){
        $chapter = Chapter::find($id);

        if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'chapter not found'
            ],404);
        }
        return response()->json([
            'status' => 'succes',
            'data:' => $chapter
        ], 200);
    }

    public function deleteById($id){
        $chapter = Chapter::find($id);

        if (!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'chapter not found'
            ], 404);
        }

        $chapter->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'chapter deleted'
        ]);
    }

    public function getAll(Request $request){
       
        $chapters = Chapter::query();
        $courseId = $request->query('course_id');

        $chapters->when($courseId, function($query) use ($courseId) {
            return $query->where('course_id', '=', $courseId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $chapters->get()
        ]);
    }
}
