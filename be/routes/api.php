<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SkillController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('members')->group(function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::post('/', [MemberController::class, 'store']);
    Route::get('/{username}/skills', [MemberController::class, 'getSkills']);
    Route::post('/{username}/skills', [MemberController::class, 'postSkill']);
    Route::put('/{username}/skills/{skillId}', [MemberController::class, 'updateSkill']);
    Route::delete('/{username}/skills/{skillId}', [MemberController::class, 'deleteSkill']);
});
