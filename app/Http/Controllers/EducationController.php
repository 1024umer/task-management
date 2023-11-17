<?php

namespace App\Http\Controllers;

use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = Education::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        return EducationResource::collection($education);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attr = $request->only('school_name','degree','area_study','start_date','end_date');
        $attr['user_id'] = auth()->user()->id;

        $education = Education::create($attr);
        return new EducationResource($education);
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education,$id)
    {
        $education->where([['user_id',auth()->user()->id],['id',$id]])->first();
        return new EducationResource($education);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        $attr = $request->only('school_name','degree','area_study','start_date','end_date');
        $education->update($attr);
        $education->save();

        return new EducationResource($education);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        $education->delete();
        return response()->json(null,200);
    }
}
