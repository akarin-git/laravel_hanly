<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Eloquents\Friendrelation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FriendShowRequest;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    protected $friend;
    protected  $relationship;

    public function __construct(Friend $friend,Friendrelation $relationship)
    {
        $this->friend = $friend;
        $this->relationship = $relationship;
    }
    
    /**
     * @param \App\Http\Requests\Api\FriendShowRequest $request
     * @param int $friendId
     * @return \App\Http\Resources\FriendResource
     */

     public function show(FriendShowRequest $request,int $friendId)
     {
         
        //  dd($friendId);
         $friend = Friend::with(['pin'])->find($friendId);

        //  $friend = $this->friend->findById($friendId);

        //  return response()->json($friend);
         return new \App\Http\Resources\FriendResource($friend);
     }

     /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\FriendCollection
     */
     public function list(Request $request)
     {
        //  dd($request->user()->id);
         $myId = $request->user()->id;

        //  Eloquentを利用して自分の友達IDを取得
         $friendIds = Friendrelation::where('own_friends_id',$myId)
                    ->get()
                    ->pluck('other_friends_id')
                    ->toArray();
                    // dd($friendIds);

            // 自分お友達の情報を取得
            $friends = Friend::with(['pin'])
                    ->whereIn('id',$friendIds)
                    ->get();
                    // dd($friends);

        //  return response()->json($friends);
         return new \App\Http\Resources\FriendCollection ($friends);
     }
}
