<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Chapter;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'video' => 'required|string',
            'chapter_id' => 'required|integer',
        
            
            
        ];
        $data = $request->all();
        $validator = Validator::make($data,$rules);
    
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $chapterId=$request->input('chapter_id');
        
        $chapter= Chapter::find($chapterId);

        if (!$chapter){
            return response()->json([
                'status'=> 'error',
                'message' => 'chapter not found'
            ],404);
        }
        $lesson = Lesson::create($data);
        return response()->json([
            'status' => 'succes',
            'data' => $lesson
        ],200);
    }

    public function update(Request $request, $id){
        $rules = [
            'name' => 'string',
            'video' => 'string',
            'chapter_id' => 'integer',
        ];
    
        $data = $request->all();
    
        $validator = Validator::make($data, $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
        $lesson = Lesson::find($id);
    
        if (!$lesson){
            return response()->json([
                'status'=> 'error',
                'message' => 'lesson not found'
            ],404);
        }
    
        // Mengambil chapter berdasarkan chapter_id
        $chapterId = $request->input('chapter_id');

    
        // Memeriksa apakah mentor ditemukan
        if ($chapterId) {
            $chapter = Chapter::find($chapterId);
           if(!$chapter){
            return response()->json([
                'status' => 'error',
                'message' => 'chapter not found'
            ], 404);
           }
        }
    
        $lesson->fill($data);
        $lesson->save();
    
        return response()->json([
            'status'=>'success',
            'data'=> $lesson
        ],200);
        }

        public function deleteById($id){
            $lesson = Lesson::find($id);

            if (!$lesson){
                return response()->json([
                    'status'=> 'error',
                    'message' => 'lesson not found'
                ], 404);
            }

            $lesson->delete();
            return response()->json([
                'status' => 'succes',
                'message' => 'lesson deleted'
            ],200);
        }

        public function getAll(Request $request){
            $lessons = Lesson::query();
        $chapterId = $request->query('chapter_id');

        $lessons->when($chapterId, function($query) use ($chapterId) {
            return $query->where('chapter_id', '=', $chapterId);
        });

        return response()->json([
            'status' => 'success',
            'data' => $lessons->get()
        ]);
        }
        
        public function getById($id){
            $lesson = Lesson::find($id);
            if(!$lesson){
                return response()->json([
                    'status'=> 'error',
                    'message' => 'lesson not found'
                ],404);
            }

            return response()->json([
                'status'=> 'succes',
                'message' => $lesson
            ],200);
        }
            
}
