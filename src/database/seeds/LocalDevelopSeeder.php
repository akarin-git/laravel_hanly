<?php

use Illuminate\Database\Seeder;

class LocalDevelopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Eloquents\Friend::create([
        //     'nickname' => '松谷',
        //     'email' => 'test@hoge.com',
        //     'password' => bcrypt('this is password'),
        //     'image_path' => null,
        //     'remember_token' => \Str::random(10),
        // ]);
        // factory(\App\Eloquents\Friend::class, 10)->create();
        
        // 友達を1名追加
        factory(\App\Eloquents\Friend::class,1)
            ->create([
                'nickname' => 'matsutani',
                'email' => 'matsutani@test.com',
            ])
                ->each(function ($friend){
                    // 友達関係を作る
                    factory(\App\Eloquents\FriendRelation::class,1)->create([
                        'own_friends_id' => $friend->id,
                    ]);

                    // ピンデータ
                    factory(\App\Eloquents\Pin::class)->create([
                        'friends_id' => $friend->id,
                    ]);
                });

                // 友達のいないユーザーを作成
                factory(\App\Eloquents\Friend::class,1)
                    ->create([
                        'nickname' => 'alone',
                        'email' => 'alone@test.com',
                    ])
                    ->each(function($friend){
                        factory(\App\Eloquents\Pin::class)->create([
                            'friends_id' => $friend->id,
                        ]);
                    });

                factory(\App\Eloquents\Friend::class,3)
                ->create()
                ->each(function ($friend){
                    factory(\App\Eloquents\FriendRelation::class,3)->create([
                        'own_friends_id' => $friend->id,
                    ]);

                    factory(\App\Eloquents\Pin::class)->create([
                        'friends_id' => $friend->id,
                    ]);
                });

                \Artisan::call('passport:client --password');

    }
}
