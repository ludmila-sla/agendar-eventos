<?php

namespace App\Http\Controllers;

use App\Http\Requests\taskRequest;
use App\Jobs\organizer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class taskController extends Controller
{
    public function create(taskRequest $request){
        $data = $request->all();
        $data['_id'] = Str::uuid();
        DB::table('tasks')->insert($data);
        organizer::dispatch($data['user'])->onqueue('tasks');//chamar ao gerar pdf
        return response([], $data ? 201 : 400);
    }
    public function edit(taskRequest $request){
        $data = $request->all();
        $data['_id'] = Str::uuid();
        DB::table('tasks')->insert($data);
        return response([], $data ? 201 : 400);
    }
    public function list($user){
        $tasks = DB::table('tasks')->where('user', $user)->get();
        return response( $tasks, 200);
    }

    public function show($task, $user){
        $task = DB::table('tasks')->where('user', $user)
        ->where('_id', $task)->first();
        return response( $task, $task ? 200 : 404);
    }
    public function delete($task, $user){
        $task = DB::table('tasks')->where('user', $user)
        ->where('_id', $task)->delete();
        return response( $task, $task ? 200 : 404);
    }
}
