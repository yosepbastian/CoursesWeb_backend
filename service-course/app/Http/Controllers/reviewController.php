<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;


class reviewController extends Controller
{
    public function create(Request $request){
        $rules = [
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'rating' => 'required|integer|max:5',
            'note'=> 'string',
            
        ];

        $data = $request->all();
        $validator = Validator::make($data,$rules);
    
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $courseId=$request->input('course_id');
        $myCourse= Course::find($courseId);
 
        if (!$myCourse){
            return response()->json([
                'status'=> 'error',
                'message' => 'Course not found'
            ],404);
        }

        $userId = $request->input('user_id');
        $user = getUser($userId);

        if($user['status'] === 'error'){
            return response()->json([
                'status' => $user['status'],
                'message' => $user['message']
            ], $user['http_code']);
        }

        $isExistReview = Review::where('course_id', '=', $courseId)
        ->where('user_id', '=', $userId)
        ->exists();

        if($isExistReview){
            return response()->json([
                'status' => 'error',
                'message' => 'review already exists'
            ],409);
        }

        $review = Review::create($data);
        return response()->json([
            'status' => 'succes',
            'data' => $review
        ],200);
    }

    public function deleteById($id){
        $review = Review::find($id);

        if (!$review){
            return response()->json([
                'status' => 'error',
                'message' => 'review not found'
            ], 404);
        }

        $review->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'review deleted'
        ],200);
    }

    public function update(Request $request, $id){
        $rules = [
            'rating' => 'integer|max:5',
            'note'=> 'string',
            
        ];
        $data = $request->all();
    
        $validator = Validator::make($data, $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
        $review = Review::find($id);
    
        if (!$review){
            return response()->json([
                'status'=> 'error',
                'message' => 'review not found'
            ],404);
        }
    
      
        $review->fill($data);
        $review->save();
    
        return response()->json([
            'status'=>'success',
            'data'=> $review
        ],200);
        }
}
