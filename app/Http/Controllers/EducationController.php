<?php

namespace App\Http\Controllers;

use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        try{
            $education = Education::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
            if($education->count() > 0){
                return EducationResource::collection($education);
            }else{
                return response()->json(['status'=>false,'message'=>'No record found']);
            }
        }catch(\Exception $e){
                return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try{
            $attr = $request->only('school_name', 'degree', 'area_study', 'start_date', 'end_date');
            $attr['user_id'] = auth()->user()->id;
    
            $education = Education::create($attr);
            return new EducationResource($education);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $education = Education::where('user_id', auth()->user()->id)->where('id',$id)->first();
            if($education){
                return new EducationResource($education);
            }else{
                return response()->json(['status'=>false,'message'=>'No record found']);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, Education $education)
    {
        try{
            $attr = $request->only('school_name', 'degree', 'area_study', 'start_date', 'end_date');
            $education->update($attr);
            $education->save();
            return new EducationResource($education);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function destroy(Education $education)
    {
        if($education){
            $education->delete();
            return response()->json(null, 200);
        }else{
            return response()->json(['status'=>false,'message'=>'No record found']);
        }
    }
}
