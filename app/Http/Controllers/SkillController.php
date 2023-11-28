<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $query = Skill::get();
        return SkillResource::collection($query);
    }
    public function store(Request $request)
    {
        $arr = $request->only('name');
        $equipment = Skill::create($arr);
        return new SkillResource($equipment);
    }
    public function show($id)
    {
        $skill = Skill::find($id);
        return new SkillResource($skill);
    }

    public function update(Request $request, Skill $equipment)
    {
        $arr = $request->only('name');
        $equipment->update($arr);
        return new SkillResource($equipment);
    }
    public function destroy($id)
    {
        $skill = Skill::find($id)->delete();
        return response()->json(null, 204);
    }
}
