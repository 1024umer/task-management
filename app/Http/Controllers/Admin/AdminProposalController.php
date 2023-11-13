<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProposalRequest;
use App\Http\Resources\ProposalResource;
use App\Models\Proposal;
use App\Repositories\{FileRepository,ListRepository};
use Illuminate\Http\Request;
class AdminProposalController extends Controller
{
    protected $listRep;
    protected $file;
    public function __construct(ListRepository $listRep, FileRepository $file)
    {
        $this->listRep = $listRep;
        $this->file = $file;
        $this->listRep->bindModel(Proposal::class);
    }
    public function index()
    {
        $query = $this->listRep->listFilteredQuery(['cover','user.name','task.title'])
        ->select('proposals.*');
        if(isset($_GET['perpage'])&&intval($_GET['perpage'])>0){
            $query=$query->paginate($_GET['perpage']);
        }else{
            $query=$query->get();
        }
        return ProposalResource::collection($query);
    }
    public function store(ProposalRequest $request)
    {
        $arr = $request->only('name', 'slug');
        $equipment = Proposal::create($arr);
        return new ProposalResource($equipment);
    }
    public function show($id)
    {
        $skill = Proposal::find($id);
        return new ProposalResource($skill);
    }

    public function update(ProposalRequest $request, Proposal $equipment)
    {
        $arr = $request->only('name', 'slug');
        $equipment->update($arr);
        return new ProposalResource($equipment);
    }
    public function destroy($id)
    {
        $skill = Proposal::find($id)->delete();
        return response()->json(null, 204);
    }
}
