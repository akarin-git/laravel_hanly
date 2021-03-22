<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class EloquentRelationTest extends TestCase
{
    
    /**
     * @test
     */
    // public function リレーションすげーよ()
    // {
    //     // Friendが１のやつを取得
    //     $friend = \App\Eloquents\Friend::find(1);

    //     // EloquentのFriend.phpで設定したメソッド名でアクセス
    //     // たったこれだけで、FriendのID１に紐づく、FriendsRelationshipのデータが取得できる！！
    //     $relationships = $friend->relationship;

    //     // １対多の「多」を取得しているので、Collectionオブジェクトだからループできる
    //     $myFriendIds = [];
    //     foreach ($relationships as $myFriend) {
    //         $myFriendIds[] = $myFriend->other_friends_id; // 友だちIDだけを取得
    //     }

    //     // ddで見てみよう
    //     dd($myFriendIds);

    //     $this->assertTrue(true);
    // }


    // public function フレンド1ピン取得()
    // {
    //     $pin  = \App\Eloquents\Friend::find(1)->pin;
        
    //         $relationships = $pin->relationship;

    //         dd($pin->toArray());

    //         $this->assertTrue(true);
    // }


    // public function ニックネーム() {
    //     $friend = \App\Eloquents\Pin::where('friends_id',1)->first()->friend;

    //     $relationships = $friend->relationship;

    //     dd($friend->nickname);

    //     $this->assertTrue(true);
    // }


    // public function Pin経由でFriendRelationShipの友達を取得()
    // {
    //    $friend = \App\Eloquents\Pin::where('friends_id',7)->first()->friend;

    //    $otherFriendIds = $friend->relationship->pluck('other_friends_id');

    //    dd($otherFriendIds);

    //    $this->assertTrue(true);
    // }


    // public function さらにそこから友達の名前の取得()
    // {
    //    $friend = \App\Eloquents\Pin::where('friends_id',7)->first()->friend;

    //    $otherFriendIds = $friend->relationship->pluck('other_friends_id');

    //     $otherFriends = \App\Eloquents\Friend::whereIn('id',$otherFriendIds)->get();

    //    dd($otherFriends->pluck('nickname'));

    //    $this->assertTrue(true);
    // }

    public function Pinを持っているFriendを取得()
    {
        $friends = \App\Eloquents\Friend::whereHas('pin')->get();

        dd($friends->toArray());

        $this->assertTrue(true);
    }
};
