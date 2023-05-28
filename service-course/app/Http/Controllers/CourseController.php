<?php

namespace App\Http\Controllers;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Models\MyCourse;
use App\Models\Review;
use App\Models\Chapter;
use App\Models\Lesson;
class CourseController extends Controller
{

    public function index(Request $request){
        $courses = Course::query();
        $q = $request->query('q');
        $status = $request->query('status');

        $courses->when($q, function($query) use ($q){
            return $query->whereRaw("name LIKE '%".strtolower($q)."%'");
        });

        $courses->when($status, function($query) use ($status){
            return $query->where('status', '=', $status);
        });
        
        return response()->json([
            'status'=> 'succes',
            'data' => $courses->paginate(10)
        ],200);

        }

        

    public function create(Request $request){
        $rules = [
            'name' => 'required|string',
            'certificate' => 'required|boolean',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published',
            'price' => 'integer',
            'level' => 'required|in:all-level,beginner,intermediate,advance',
            'mentor_id' => 'required|integer',
            'description' => 'required|string'
            
        ];
        $data = $request->all();
        $validator = Validator::make($data,$rules);
    
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $mentorId=$request->input('mentor_id');
        
        $mentor= Mentor::find($mentorId);

        if (!$mentor){
            return response()->json([
                'status'=> 'error',
                'message' => 'mentor not found'
            ],404);
        }
        $course = Course::create($data);
        return response()->json([
            'status' => 'succes',
            'data' => $course
        ],200);
    }

    public function getAll(){
        $course = Course::all();

        return response()->json([
            'status'=> 'succes',
            'data' => $course
        ],200);
    }

    public function getById($id){
        $course = Course::with('chapters.lesson')
        ->with('mentor')
        ->with('images')
        ->find($id);

        if(!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ],404); 
        }

        $reviews = Review::where('course_id', '=', $id)->get()->toArray();
        if (count($reviews) > 0){
            $usersIds = array_column($reviews, 'user_id');
            $users = getUserById($usersIds);
             if($users['status'] === 'error'){
                $reviews = [];
                
             }else {
                foreach($reviews as $key => $review) {
                    $userIndex = array_search($review['user_id'], array_column($users['data'], 'id'));
                    $reviews[$key]['users'] = $users['data'][$userIndex];       
                }
        }   
    }

        $totalStudent = MyCourse::where('course_id', '=', $id)->count();
        $totalVideos = Chapter::where('course_id', '=', $id)->withCount('lesson')->get()->toArray();

        $finalTotalVideos = array_sum(array_column($totalVideos, 'lesson_count'));

        $course['reviews'] =$reviews;
        $course['total_videos']=$finalTotalVideos;
        $course['total_student'] = $totalStudent;

        return response()->json([
            'status' => 'succes',
            'data:' => $course
        ], 200);
    }

    public function update(Request $request, $id){
    $rules = [
        'name' => 'string',
        'certificate' => 'boolean',
        'thumbnail' => 'string|url',
        'type' => 'in:free,premium',
        'status' => 'in:draft,published',
        'price' => 'integer',
        'level' => 'in:all-level,beginner,intermediate,advance',
        'mentor_id' => 'integer', // menambahkan exists:mentors,id untuk memeriksa apakah mentor_id tersebut ada di dalam database
        'description' => 'string'
    ];

    $data = $request->all();

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()
        ], 400);
    }
    $course = Course::find($id);

    if (!$course){
        return response()->json([
            'status'=> 'error',
            'message' => 'course not found'
        ],404);
    }

    
    // Mengambil course berdasarkan mentor_id
    $mentorId = $request->input('mentor_id');
    
 
    // Memeriksa apakah course ditemukan
    if ($mentorId) {
        $mentor = Mentor::find($mentorId);
        if(!$mentor){
            return response()->json([
                'status' => 'error',
                'message' => 'mentor not found'
            ], 404);
        }
    
       
    }

    $course->fill($data);
    $course->save();

    return response()->json([
        'status'=>'success',
        'data'=> $course
    ],200);
    }

    public function deleteById($id){
        $course = Course::find($id);

        if (!$course){
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ], 404);
        }

        $course->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'course deleted'
        ],200);
    }

  

}
