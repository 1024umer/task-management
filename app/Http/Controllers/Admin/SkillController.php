<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use App\Repositories\{ListRepository,FileRepository};
use Illuminate\Http\Request;
class SkillController extends Controller
{
    protected $listRep;
    protected $file;
    public function __construct(ListRepository $listRep, FileRepository $file)
    {
        $this->listRep = $listRep;
        $this->file = $file;
        $this->listRep->bindModel(Skill::class);
    }
    public function index()
    {
        $query = $this->listRep->listFilteredQuery([ 'name', 'slug'])
        ->select('skills.*');
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return SkillResource::collection($query);
    }
    public function store(SkillRequest $request)
    {
        $arr = $request->only('name', 'slug');
        $equipment = Skill::create($arr);
        return new SkillResource($equipment);
    }
    public function show($id)
    {
        $skill = Skill::find($id);
        return new SkillResource($skill);
    }

    public function update(SkillRequest $request, Skill $equipment)
    {
        $arr = $request->only('name', 'slug');
        $equipment->update($arr);
        return new SkillResource($equipment);
    }
    public function destroy($id)
    {
        $skill = Skill::find($id)->delete();
        return response()->json(null, 204);
    }
}
