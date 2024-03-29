<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Skill;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $file;
    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }
    public function index()
    {
        $tasks = Task::orderBy("id", "desc")->with('project_file', 'project_cover')->get();
        return TaskResource::collection($tasks);
    }
    public function store(TaskRequest $request)
    {
        try {
            // Gate::authorize('create',Task::class);
            if(auth()->user()->role_id == User::STUDENT_ROLE){
                $attr = $request->only('title', 'description', 'start_date', 'end_date', 'budget', 'skills');
                $attr['user_id'] = auth()->user()->id;
                $task = Task::create($attr);
                if ($request->project_cover) {
                    $this->file->create([$request->project_cover], 'project_cover', $task->id, 1);
                }
                if ($request->project_file) {
                    foreach ($request->project_file as $file) {
                        $this->file->create([$file], 'project_file', $task->id, 2);
                    }
                }
                return new TaskResource($task);
            }else{
                return response()->json(['message' => 'You are not allowed to create task']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 302]);
        }
    }
    public function show($id)
    {
        // Gate::authorize('view',Task::class);
        $task = Task::where('id', $id)->with('project_cover', 'project_file')->first();
        return new TaskResource($task);
    }
    public function update(TaskRequest $request, Task $task)
    {
        try {
            // Gate::authorize('update',Task::class);
            $attr = $request->only('title', 'description', 'start_date', 'end_date', 'budget', 'skills');
            $task->update($attr);
            if ($request->project_cover) {
                $this->file->create([$request->project_cover], 'project_cover', $task->id, 1);
            }
            if ($request->project_file) {
                $this->file->create([$request->project_file], 'project_file', $task->id, 1);
            }
            return new TaskResource($task);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 302]);
        }
    }
    public function destroy(Task $task)
    {
        try {
            // Gate::authorize('delete',Task::class);
            $task->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 302]);
        }
    }
    public function mostRecent()
    {
        $task = Task::orderBy("id", "desc")->with('project_file', 'project_cover')->latest()->take(15)->get();
        return new TaskResource($task);
    }
    public function bestMatch()
    {
        try {
            $userSkills = auth()->user()->skills;
            $userSkillsArray = json_decode($userSkills, true);

            $tasks = Task::where(function ($query) use ($userSkillsArray) {
                foreach ($userSkillsArray as $skill) {
                    $query->orWhereJsonContains('skills', $skill);
                }
            })->with('project_file', 'project_cover')->get();

            if ($tasks->count() > 0) {
                return new TaskResource($tasks);
            } else {
                return response()->json(['message' => 'No Tasks found according to your skills']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function all()
    {
        $task = Task::where('user_id', auth()->user()->id)
            ->orderBy("id", "desc")->with('project_file', 'project_cover')->get();
        if ($task->count() > 0) {
            return new TaskResource($task);
        } else {
            return response()->json(['message' => 'No Task available']);
        }
    }
    public function progress()
    {
        $task = Task::where('user_id', auth()->user()->id)->where('is_progress', 1)
            ->orderBy("id", "desc")->with('project_file', 'project_cover')->get();
        if ($task->count() > 0) {
            return new TaskResource($task);
        } else {
            return response()->json(['message' => 'No Progress task available']);
        }
    }
    public function completed()
    {
        $task = Task::where('user_id', auth()->user()->id)->where('is_completed', 1)
            ->orderBy("id", "desc")->with('project_file', 'project_cover')->get();
        if ($task->count() > 0) {
            return new TaskResource($task);
        } else {
            return response()->json(['message' => 'No Completed task available']);
        }
    }
}
