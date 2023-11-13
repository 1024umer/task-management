<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\{TaskController,ProposalController};
use App\Http\Controllers\Admin\{SkillController,UserController,RoleController,AdminTaskController,AdminProposalController};
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
});

Route::group(['middleware' => ['cors', 'json.response','auth:api']], function () {
	Route::post('/logout', [ApiAuthController::class, 'logout']);
	Route::apiResource('task',TaskController::class);
	Route::post('create-proposal/{id}',[ProposalController::class,'createProposal']);
	
	//Admin
	Route::apiResource('skill',SkillController::class);
	Route::apiResource('admin-task',AdminTaskController::class);
	Route::apiResource('admin-proposal',AdminProposalController::class);
	Route::apiResource('users',UserController::class);
	Route::apiResource('roles',RoleController::class);
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
});