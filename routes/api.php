<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TarefasController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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



Route::post("/login", [AuthController::class, 'login']);
Route::post("/register", [UserController::class, 'userRegister']);
Route::get("/logout", [AuthController::class, 'logout']);

Route::group(["middleware" => ["api", "auth"]], function () {
    Route::group(["prefix" => "user", "controller" => UserController::class], function() {
            Route::get("/list", "list");
            Route::get("/list/{id}", "listById");
    });

    Route::group(["prefix" => "task", "controller" => TaskController::class], function() {
        Route::get("/list", "list");
        Route::get("/list/{id}", "listById");
        Route::get("/user", "listUserTasks");
        Route::post("/register", "registerTask");
        Route::put("/update/{id}", "updateTask");
        Route::delete("/delete/{id}", "deleteTask");
    });

});

Route::fallback(function ($e) {
    return response()->json([
        "status"  => false,
        "message" => "Route not found."
    ], 404);
});
