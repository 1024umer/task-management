<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $file;
    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return new UserResource($user);
    }
    public function update(Request $request, $id)
    {
        try {
            $attr  = $request->only('username', 'name', 'dob', 'gender', 'phone', 'country_id', 'college', 'about_me');
            $user = User::where('id', $id)->first();
            $user->update($attr);
            if ($request->image) {
                $this->file->create([$request->image], 'users', $user->id, 1);
            }
            return new UserResource($user);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
