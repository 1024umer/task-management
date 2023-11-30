<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProposalRequest;
use App\Http\Resources\ProposalResource;
use App\Models\Proposal;
use App\Models\Task;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
class ProposalController extends Controller
{
    protected $file;
    public function __construct(FileRepository $file){
        $this->file = $file;
    }
    public function createProposal(ProposalRequest $request, $id){
        try{
            $task = Task::find($id);
            if($task){
                $attr = $request->only('duration','cover','amount');
                $attr['user_id'] = auth()->user()->id;
                $attr['task_id'] = $id;
                $proposal = Proposal::create($attr);
                if ($request->hasFile('proposal_images')) {
                        $this->file->create([$request->proposal_images], 'proposal', $proposal->id,2);
                    }
                    return new ProposalResource($proposal);
                }else{
                return response()->json(['success'=>false,'message'=>'This proposal is no longer available',302]);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false,'message'=>'There is some error while creating the proposal',302]);
        }
    }
}
