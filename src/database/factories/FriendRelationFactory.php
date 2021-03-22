<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eloquents\FriendRelation;
use Faker\Generator as Faker;
use GuzzleHttp\Promise\Create;

$factory->define(FriendRelation::class, function (Faker $faker) {
    return [
        'own_friends_id' => factory(\App\Eloquents\Friend::class)->create()->id,
        'other_friends_id' => factory(\App\Eloquents\Friend::class)->create()->id,
    ];
});
