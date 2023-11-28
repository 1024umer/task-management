<?php

use App\Http\Controllers\Auth\{ApiAuthController,ForgetPasswordController};
use App\Http\Controllers\{CountryController,WorkController,StatsController,ProfileController,TaskController,ProposalController,EducationController,EmployemnetController};
use App\Http\Controllers\Admin\{AdminEducationController,SkillController,UserController,RoleController,AdminTaskController,AdminProposalController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => ['cors', 'json.response']], function () {
	Route::post('/register', [ApiAuthController::class, 'register']);
	Route::post('/login', [ApiAuthController::class, 'login']);
	Route::post('/admin-login', [ApiAuthController::class, 'adminLogin']);
	Route::apiResource('country',CountryController::class)->only(['index']);
});

Route::group(['middleware' => ['cors', 'json.response','auth:api']], function () {
	Route::post('/logout', [ApiAuthController::class, 'logout']);
	Route::apiResource('task',TaskController::class);
	Route::post('create-proposal/{id}',[ProposalController::class,'createProposal']);
	Route::apiResource('employement',EmployemnetController::class);
	Route::apiResource('education',EducationController::class);
	Route::apiResource('profile',ProfileController::class);
	Route::apiResource('stats',StatsController::class)->only(['index']);
	Route::apiResource('work',WorkController::class);
	Route::post('review/{$id}',[WorkController::class,'inReview']);
	Route::post('pending/{$id}',[WorkController::class,'inPending']);
	Route::post('completed/{$id}',[WorkController::class,'inCompleted']);
	//Admin
	Route::apiResource('skill',SkillController::class);
	Route::apiResource('admin-task',AdminTaskController::class);
	Route::apiResource('admin-education',AdminEducationController::class);
	Route::apiResource('admin-proposal',AdminProposalController::class);
	Route::apiResource('users',UserController::class);
	Route::apiResource('roles',RoleController::class);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
});

//Forget Password Starts here

// Route::get('/forget-password', [ForgetPasswordController::class, 'index'])->name('auth.forgetPassword');
Route::post('/otp-send', [ForgetPasswordController::class, 'otpSend'])->middleware('guest');
Route::post('/otp-verify',[ForgetPasswordController::class,'reset'])->middleware('guest');
Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword'])->middleware('guest');
//Forget Password Ends here