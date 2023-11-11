<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\{FileRepository,ListRepository};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $listRep;
    protected $file;
    public function __construct(ListRepository $listRep, FileRepository $file)
    {
        $this->listRep = $listRep;
        $this->file = $file;
        $this->listRep->bindModel(User::class);
    }
    public function index()
    {
        // Gate::authorize('viewAny',Merchant::class);
        $query = $this->listRep->listFilteredQuery(['name', 'username', 'phone'])
            ->select('users.*')->where('id','!=',auth()->user()->id)
            ->with('image');
        if(isset($_GET['role_id'])){
            $query = $query->where('role_id',$_GET['role_id']);
        }
        if (isset($_GET['perpage']) && intval($_GET['perpage']) > 0) {
            $query = $query->paginate($_GET['perpage']);
        } else {
            $query = $query->get();
        }
        return UserResource::collection($query);
    }
    public function store(RegisterRequest $request){
        $attr = $request->only('name','username','phone','role_id','email','country_id','skill_id');
        $attr['password'] = Hash::make($request->password);
        $user = User::create($attr);
        if($request->image){
            $this->file->create([$request->image],'users',$user->id,1);
        }
        return new UserResource($user);
    }
    public function show($id){
        $user = User::where('id',$id)->with('image')->first();
    }
    public function destroy($id){
        $user = User::find($id)->delete();
    }
}
