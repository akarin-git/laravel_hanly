<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class EloquentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

//    /**
//     * @test
//     */
//    public function IDを指定して１件取得()
//    {
//        $friend = \App\Eloquents\Friend::find(1);

//        dd($friend);

//        $this->assertTrue(true);
//    }


// /**
//     * @test
//     */
//     public function 全権取得取得()
//     {
//         $friend = \App\Eloquents\Friend::all();
 
//         dd($friend);
 
//         $this->assertTrue(true);
//     }

/**
    * @test
    */
    // public function １件登録()
    // {
    //     $newfriend = \App\Eloquents\Friend::create([
    //         'nickname' => '田中',
    //         'email' => 'hogefuga@test.com',
    //         'password' => bcrypt('passsword-desu'),
    //         'image_path' => null,
    //         'remenber_token' => \Str::random(80),
    //     ]);

    //     dd($newfriend);

    //     $this->assertTrue(true);
    // }

     /**
     * @test
     */
    // public function 条件を指定して取得（ニックネームにmatsuを含む人）()
    // {
    //     // これはCollectionになるのです！
    //     $friends = \App\Eloquents\Friend::where('nickname', 'like', '%matsu%')->get();

    //     dd($friends);

    //     $this->assertTrue(true);
    // }

    /**
     * @test
     */
    // public function Friendのデータを更新()
    // {
    //    $friend = \App\Eloquents\Friend::find(1);
    //    $friend->fill([
    //        'nickname' => 'matsumatsu',
    //    ])
    //    ->save();
    //    dd($friend);

    //    $this->assertTrue(true);
    // }
    /**
     * @test
     */
    public function FriendのID2のデータを削除()
    {
    //    IDを指定して削除
        $delete = \App\Eloquents\Friend::destroy(3);

        // 削除した件数が返る
        dd($delete);
        
        // // いろんな条件で検索して削除する場合
        // $delete = \App\Eloquents\Friend::where('nickname', 'like', '%matsu%')->delete();
        // dd($delete);
        $this->assertTrue(true);
    }
}
