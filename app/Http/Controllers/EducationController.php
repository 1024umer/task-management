<?php

namespace App\Http\Controllers;

use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return EducationResource::collection($education);
    }

    public function store(Request $request)
    {
        $attr = $request->only('school_name', 'degree', 'area_study', 'start_date', 'end_date');
        $attr['user_id'] = auth()->user()->id;

        $education = Education::create($attr);
        return new EducationResource($education);
    }

    public function show($id)
    {
        try {
            $education  = Education::where('user_id', auth()->user()->id)->where('id', $id)->first();
            return new EducationResource($education);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Did not find the Education', 200]);
        }
    }

    public function update(Request $request, Education $education)
    {
        $attr = $request->only('school_name', 'degree', 'area_study', 'start_date', 'end_date');
        $education->update($attr);
        $education->save();

        return new EducationResource($education);
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return response()->json(null, 200);
    }
}
