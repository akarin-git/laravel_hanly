<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeController extends Controller
{
    
        // return response()->json([
        //             'id' => 1,
        //             'nickname' => 'ニックネーム',
        //             'email' => 'test@example.com',
        //             'image_url' => 'null',
        //             'pin' => [
        //                 'datetime' => '2020-04-19T07:58:20.108Z',
        //                 'latitude' => 33.33333,
        //                 'lognitude' => 111.111111,
        //             ],
        //         ]);

        protected $friend;

    public function __construct(Friend $friend)
    {
        $this->friend = $friend;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\FriendResource
     */
    public function me(Request $request)
    {
        $myId = $request->user()->id;
        
        $myInfo = Friend::with(['pin'])->find($myId);
        // dd($myInfo);

       // とりあえず、そのままレスポンスします（後ほど整形します）
        // return response()->json($myInfo);
        return new \App\Http\Resources\FriendResource($myInfo);
    }
}
