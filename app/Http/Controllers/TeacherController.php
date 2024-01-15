<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeacherResource;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function allTeachers(){
        try{
            $allTeachers = User::where('role_id',User::TEACHER_ROLE)->with('country')->get();
            if($allTeachers->count() > 0){
                return new TeacherResource($allTeachers);
            }else{
            return response()->json(['status'=>false,'message'=>'No record found']);
            }
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
    public function singleTeacher($id){
        try{
            $teacher = User::where('id',$id)->where('role_id',User::TEACHER_ROLE)->with('country')->first();
            if($teacher > 0){
                return new TeacherResource($teacher);
            }else{
            return response()->json(['status'=>false,'message'=>'No record found']);
            }
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
}
