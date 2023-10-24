<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;





Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('signin', [AuthController::class, 'signin']);
Route::get('/user', [AuthController::class, 'getUser'])->middleware('auth:api');

Route::prefix("/v1")->group(function () {

    
    Route::get('/province', [LevelController::class, 'provinces']);
    Route::get('/district', [LevelController::class, 'districts']);
    Route::get('/sector', [LevelController::class, 'sectors']);
    // Route::get('/cells', [LevelController::class, 'cells']);


    Route::get("/schools", [SchoolController::class, "index"]);
    Route::get("/school-info", [SchoolController::class, "schoolDetails"]);
    Route::post("/school", [SchoolController::class, "store"]);

    Route::get("levels", [LevelController::class, "index"]);
    Route::get("level/{id}", [LevelController::class, "show"]);
    Route::put("level/{id}", [LevelController::class, "update"]);
    Route::post("levels", [LevelController::class, "store"]);

    Route::get("subjects", [SubjectController::class, "index"]);
    Route::post("subjects", [SubjectController::class, "store"]);
    


    Route::get("units", [UnitController::class, "index"]);
    Route::get("subjects/{id}", [UnitController::class, "unitPerSubject"]);
    Route::get("units/subjects/{id}", [UnitController::class, "SubjectName"]);
    Route::post("units", [UnitController::class, "store"]);


    });

    Route::group(['middleware' => 'auth:sunctum'], function(){
        Route::get('/topics',[TopicController::class, "index"]);
    });