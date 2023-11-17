<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployementRequest;
use App\Http\Resources\EmployementResource;
use App\Models\Employement;
use Illuminate\Http\Request;

class EmployemnetController extends Controller
{
    public function index(){
        $employement = Employement::where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        return EmployementResource::collection($employement);
    }
    public function store(EmployementRequest $request){
        try{
            $attr = $request->only('company_name','designation','city','country_id','start_date','end_date','description','is_working');
            $attr['user_id'] = auth()->user()->id;
    
            $employemnet = Employement::create($attr);
            return new EmployementResource($employemnet);
        }catch(\Exception $e){
            return response()->json(['error'=> 'There is some issue while creating Employemnts',302]);
        }
    }
    public function show($id){
        try{
            $employemnt  = Employement::where([['user_id',auth()->user()->id],['id',$id]])->first();
            return new EmployementResource($employemnt);
        }catch(\Exception $e){
            return response()->json(['error'=> 'Did not find the Employement',200]);
        }
    }
    public function update(Request $request, $id){
        try{
            $employement = Employement::where([['user_id',auth()->user()->id],['id',$id]])->first();
            if($employement){
                $attr = $request->only('company_name','designation','city','country_id','start_date','end_date','description','is_working');
                $employement->update($attr);
                $employement->save();

                return new EmployementResource($employement);
            }else{
                return response()->json(['message'=> 'This employemnt does not exsist anymore',200]);
            }

        }catch(\Exception $e){
            return response()->json(['error'=>'There is some error while updating',302]);
        }
    }
    public function destroy($id){
        $employemnt = Employement::where([['user_id',auth()->user()->id],['id',$id]])->delete();
        return response()->json(null,200);
    }
}
