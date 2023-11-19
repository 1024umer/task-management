<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationRequest;
use App\Http\Resources\EducationResource;
use Illuminate\Http\Request;
use App\Repositories\{ListRepository,FileRepository};
use App\Models\Education;
class AdminEducationController extends Controller
{
    protected $listRep;
    protected $file;
    public function __construct(ListRepository $listRep, FileRepository $file)
    {
        $this->listRep = $listRep;
        $this->file = $file;
        $this->listRep->bindModel(Education::class);
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
        return EducationResource::collection($query);
    }
    public function store(EducationRequest $request)
    {
        $arr = $request->only('name', 'slug');
        $equipment = Education::create($arr);
        return new EducationResource($equipment);
    }
}
