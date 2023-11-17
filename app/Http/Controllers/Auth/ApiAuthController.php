<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    protected $file;
    public function __construct(FileRepository $file){
        $this->file = $file;
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->is_email_verified == 1) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Task Management Token Grant')->accessToken;
                    $response = ['token' => $token, 'user' => $user];
                    return response($response, 200);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 422);
                }
            } else {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Task Management Token Grant')->accessToken;
                    $response = ['token' => $token, 'user' => $user];
                    return response($response, 200);
                }
                $response = ["message" => "Password doesn't match"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }
    public function adminLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user && $user->role_id == 1) {
            if ($user->is_email_verified == 1) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Task Management Token Grant')->accessToken;
                    $response = ['token' => $token, 'user' => $user];
                    return response($response, 200);
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 422);
                }
            } else {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('Task Management Token Grant')->accessToken;
                    $response = ['token' => $token, 'user' => $user];
                    return response($response, 200);
                }
                $response = ["message" => "Password doesn't match"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'User does not exist'];
            return response($response, 422);
        }
    }
    public function register(RegisterRequest $request){
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'country_id' =>$request->country_id,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'skill_id' => $request->skill_id,
        ]);
        if($request->image){
            $this->file->create([$request->image],'users',$user->id,1);
        }
        $token = $user->createToken('Task Management Token Grant')->accessToken;
        $user_detail = User::where('id', $user->id)->first();
        $response = ['token' => $token, 'user' => $user_detail];
        return response($response, 200);
    }
    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
