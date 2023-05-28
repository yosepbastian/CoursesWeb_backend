<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{

    public function getAll(){
        $mentor = Mentor::all();
        return response()->json([
            'status:' => 'succes',
            'data:' => $mentor
        ],200);
    }

    public function getById($id){
        $mentor = Mentor::find($id);

        if (!$mentor){
            return response()->json([
                'status:'=> 'error',
                'message:' => 'id mentor not found'
            ],404);
        }

        return response()->json([
            'status' => 'succes',
            'data:' => $mentor
        ], 200);
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email|unique:mentors,email'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $mentor = Mentor::create($data);

        return response()->json(['status' => 'success', 'data' => $mentor]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }
        $mentor = Mentor::find($id);

        if (!$mentor){
            return response()->json([
                'status'=> 'error',
                'message' => 'mentor not found'
            ],404);
        }

        $mentor->fill($data);
        $mentor->save();

        return response()->json([
            'status'=>'succes',
            'data'=> $mentor
        ],200);
    }

    public function deleteById($id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }

        $mentor->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'mentor deleted'
        ]);
    }
}
