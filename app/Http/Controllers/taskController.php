<?php

namespace App\Http\Controllers;

use App\Http\Requests\taskRequest;
use App\Jobs\organizer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class taskController extends Controller
{
    public function create(taskRequest $request, $user)
    {
        $data = $request->all();
        $data['_id'] = Str::uuid();
        $data['user'] = $user;
        DB::table('tasks')->insert($data);
        return response([], $data ? 201 : 400);
    }
    public function delete($task, $user)
    {
        $task = DB::table('tasks')->where('user', $user)
            ->where('_id', $task)->delete();
        return response($task, $task ? 200 : 404);
    }
    public function edit(taskRequest $request, $id)
    {
        $data = $request->all();
        DB::table('tasks')->where('_id', $id)->update($data);
        return response([], $data ? 201 : 400);
    }
    public function list($user)
    {
        $tasks = DB::table('tasks')->where('user', $user)->get();
        return response($tasks, 200);
    }
    public function pdf($user)
    {
        organizer::dispatch($user)->onqueue('tasks');
        return response([], 200);
    }
    public function show($task, $user)
    {
        $task = DB::table('tasks')->where('user', $user)
            ->where('_id', $task)->first();
        return response($task, $task ? 200 : 404);
    }
}
