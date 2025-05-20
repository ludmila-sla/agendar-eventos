<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::post('user/create', [UserController::class, 'create']);
Route::delete('user/delete/{id}', [UserController::class, 'delete']);

Route::post('task/create/{user}', [TaskController::class, 'create']);
Route::delete('task/delete/{id}', [TaskController::class, 'delete']);
Route::post('task/edit/{id}', [TaskController::class, 'edit']);
Route::post('task/list/{user}', [TaskController::class, 'list']);
Route::post('task/pdf/{user}', [TaskController::class, 'pdf']);
Route::post('task/show/{id}/{user}', [TaskController::class, 'show']);


