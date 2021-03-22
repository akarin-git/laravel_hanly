<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\Http\Requests\Api\SignupRequest;

class SignupController extends Controller
{

    /**
     * @param \App\Http\Requests\Api\SignupRequest $request
    */
    public function signup(SignupRequest $request)
    {
        // route/apiから引っ越してきた
        // return response()->json([
        //     'id' => 1,
        //     'nickname' => 'ニックネーム',
        //     'email' => 'test@example.com'
        // ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $nickname = $request->input('nickname');

        // Eloquentを使ってDBに保存します
        $stored = \App\Eloquents\Friend::create([
            'email' => $email,
            'password' => bcrypt($password),
            'nickname' => $nickname,
        ]);


        // とりあえずレスポンスを返す
        // return response()->json($stored);
        return new \App\Http\Resources\AccountResource($stored);
    }
}
