<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\{ListRepository,FileRepository};
use Illuminate\Http\Request;
class AdminTaskController extends Controller
{
    protected $listRep;
    protected $file;
    public function __construct(ListRepository $listRep, FileRepository $file)
    {
        $this->listRep = $listRep;
        $this->file = $file;
        $this->listRep->bindModel(Task::class);
    }
    public function index()
    {
        $query = $this->listRep->listFilteredQuery(['title','description'])
        ->select('tasks.*');
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return TaskResource::collection($query);
    }
    public function store(TaskRequest $request)
    {
        $arr = $request->only('name', 'slug');
        $equipment = Task::create($arr);
        return new TaskResource($equipment);
    }
    public function show($id)
    {
        $skill = Task::find($id);
        return new TaskResource($skill);
    }

    public function update(TaskRequest $request, Task $equipment)
    {
        $arr = $request->only('name', 'slug');
        $equipment->update($arr);
        return new TaskResource($equipment);
    }
    public function destroy($id)
    {
        $skill = Task::find($id)->delete();
        return response()->json(null, 204);
    }
}
