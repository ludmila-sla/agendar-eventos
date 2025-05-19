<?php

namespace App\Http\Controllers;

use App\Http\Requests\userRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class userController extends Controller
{
    public function create(userRequest $request){
        $data = $request->all();
        $data['_id'] = Str::uuid();
        DB::table('users')->insert($data);
        return response([], $data ? 201 : 400);
    }
    public function delete($user){
        $user = DB::table('tasks')->where('user', $user)->delete();
        return response( $user, $user ? 200 : 404);
    }
}
