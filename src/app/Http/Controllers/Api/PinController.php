<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Eloquents\Friendrelation;
use App\Eloquents\Pin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PinRequest;
use Illuminate\Http\Request;
use Facades\App\Contracts\Distance;

class PinController extends Controller
{
    protected $pin;
    protected $friend;
    protected $friendRelationship;

    public function __construct(
        Pin $pin,
        Friend $friend,
        Friendrelation $friendRelationship
    ) {
        $this->pin = $pin;
        $this->friend = $friend;
        $this->friendRelationship = $friendRelationship;
    }

    /**
     * @param \App\Http\Requests\Api\PinRequest $request
     * @return \App\Http\Resources\FriendCollection
     */
    public function store(PinRequest $request)
    {
        $newFriends = \DB::transaction(function() use ($request){
            $myFriendId = $request->user()->id;

            // PINを削除
            Pin::where('friends_id',$myFriendId)->delete();

            // PINを登録
            $myPin = new Pin();
            $myPin->fill([
                'friends_id' => $myFriendId,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);
            $myPin->save();

            
            // すでに友達の人
            $myFriends = Friendrelation::where(
                'own_friends_id',
                $myFriendId
                )->get();
                
                // dd($myFriends);
            
            // まだ友達でない人
            $notFriends = Friend::with(['pin'])
                    ->where('id','<>',$myFriendId)
                    ->whereNotIn(
                        'id',
                        $myFriends->pluck('other_friends_id')->toArray()
                    )
                    ->whereHas('pin',function($query){
                        $query->where('created_at','>=',now()->subMinutes(5));
                    })
                    ->get();

                    // dd($notFriends);
            // 近くのピンの人を探す
            $canBeFriendIds = Distance::canBeFriends(
                $myPin->toArray(),
                $notFriends->pluck('pin')->toArray()
            );
            
            // 近くのピンのhitoがいれば友達になる
            foreach ($canBeFriendIds as $othersId){
                // 自分の友達として登録
                $myRelation = new Friendrelation();
                $myRelation->fill([
                    'own_friends_id' => $myFriendId,
                    'other_friends_id' => $othersId,
                ]);
                $myRelation->save();

                // 相手の友達として登録
                $otherRelation = new Friendrelation();
                $otherRelation->fill([
                    'own_friends_id' => $othersId,
                    'other_friends_id' => $myFriendId,
                ]);
                $otherRelation->save();
            }

            // 新しく友達になった人
            return Friend::with(['pin'])
                ->whereIn('id',$canBeFriendIds)
                ->get();
        });

        // dd($newFriends);
        // レスポンスはとりあえず、そのまま返す（後で成形する）
        // return response()->json($newFriends);
        return new \App\Http\Resources\FriendCollection($newFriends);
    }
}
