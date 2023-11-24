<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkResource;
use App\Models\Proposal;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index(){
        $work = Work::where('proposal.user_id',auth()->user()->id)->get();
        return WorkResource::collection($work);
    }
    public function create(Request $request){
        $proposal = Proposal::where('id',$request->id);
        if($proposal){
            $work = Work::create([
                'proposal_id' => $request->id,
            ]);
            return new WorkResource($work);
        }else{
            return response()->json(['message'=>'The proposal is no longer available',302]);
        }
    }
    public function inReview($id){
        $work = Work::where('id',$id)->first();
        if($work){
            $work->update([
                'is_progress'=>0,
                'is_pending'=>0,
                'is_completed'=>0,
                'is_review'=>1
            ]);
            $work->refresh();
            return new WorkResource($work);
        }else{
            return response()->json(['message'=>'There is some error while completing please try again after sometime']);
        }
    }
    public function inPending($id){
        $work = Work::where('id',$id)->first();
        if($work){
            $work->update([
                'is_review'=>0,
                'is_completed'=>0,
                'is_progress'=>0,
                'is_pending'=>1
            ]);
            $work->refresh();
            return new WorkResource($work);
        }else{
            return response()->json(['message'=>'There is some error while completing please try again after sometime']);
        }
    }
    public function inCompleted($id){
        $work = Work::where('id',$id)->first();
        if($work){
            $work->update([
                'is_pending'=>0,
                'is_progress'=>0,
                'is_review'=>0,
                'is_completed'=>1
            ]);
            $work->refresh();
            return new WorkResource($work);
        }else{
            return response()->json(['message'=>'There is some error while completing please try again after sometime']);
        }
    }
}
