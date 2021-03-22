<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 例 get
// Route::get('/hoge', function (Request $request) {
//     // こんな感じでレスポンスを作ります。
//     return response()->json([
//         'hoge' => 'ふが',
//     ]);
// });

// 一覧を取得する場合はこんな感じでレスポンスを作ります
// Route::get('/fuga', function (Request $request) {
//     // こんな感じでレスポンスを作ります。
//     return response()->json([
//       [
//         'hoge' => 'fuga',
//       ],
//       [
//         'hoge' => 'aaa',
//       ],
//       [
//         'hoge' => 'bbb',
//       ],
//     ]);
// });

// GET /hoge/{id}の場合
// Route::get('/hoge/{id}', function (Request $request, int $id) {
//     // パスパラメータは、こんな風に取得します。
//     return response()->json([
//         'id' => $id,
//     ]);
// });

// POST /hogeの場合
// Route::post('/hoge', function (Request $request) {
//     // ここにEloquent使った登録処理もかけます。(以下、適当）
//     \App\Eloquents\Hoge::create($request->all());

//     return response(\App\Eloquents\Fuga::find(1));
// });

// Route::post('/signup',function(Request $request){
//     return response()->json([
//         'id' => 1,
//         'nickname' => 'ニックネーム',
//         'email' => 'test@example.com'
//     ]);
// });
Route::post('/signup','Api\SignupController@signup')->name('api.signup.post');


// 認証
Route::middleware('auth:api')->group(function() {
// 下のものは認証がないとエラーを吐く

// Route::get('me',function(Request $request){
//     return response()->json([
//         'id' => 1,
//         'nickname' => 'ニックネーム',
//         'email' => 'test@example.com',
//         'image_url' => 'null',
//         'pin' => [
//             'datetime' => '2020-04-19T07:58:20.108Z',
//             'latitude' => 33.33333,
//             'lognitude' => 111.111111,
//         ],
//     ]);
// });
Route::get('me','Api\MeController@me')->name('api.me.get');

// Route::post('/my/image',function(Request $request) {
//     return response()->json([
//         'image_url' => 'http://localhost/images/1',
//     ]);
// });
Route::post('/my/image', 'Api\ImageController@store')->name('api.my.image.post');


// Route::post('/my/pin',function(Request $request){
//     return response()->json([
//         [
//             'id' => 1,
//             'nickname' => 'ニックネーム',
//             'email' => 'test@example.com',
//             'image_url' => null,
//             'pin' => [
//                 'datetime' => '2020-04-19T07:58:20.108Z',
//                 'latitude' => 33.33333,
//                 'lognitude' => 111.111111,
//             ],
           
//         ],
//         [
//             'id' => 2,
//             'nickname' => 'ニックネーム',
//             'email' => 'test@example.com',
//             'image_url' => null,
//             'pin' => [
//                 'datetime' => '2020-04-19T07:58:20.108Z',
//                 'latitude' => 33.33333,
//                 'lognitude' => 111.111111,
//             ],
//         ],
//     ]);
// });
Route::post('/my/pin', 'Api\PinController@store')->name('api.my.pin.post');

// Route::get('/friends',function(Request $request){
//     return response()->json([
//         [
//             'id' => 1,
//             'nickname' => 'あああああ',
//             'email' => 'test@example.com',
//             'image_url' => null,
//             'pin' => [
//                 'datetime' => '2020-04-19T07:58:20.108Z',
//                 'latitude' => 33.33333,
//                 'longitude' => 111.11111,
//             ],
//         ],
//         [
//             'id' => 2,
//             'nickname' => 'ニックネーム',
//             'email' => 'test@example.com',
//             'image_url' => null,
//             'pin' => null,
//         ],
//     ]);
// });
Route::get('friends','Api\FriendController@list')->name('api.friends.list.get');

// Route::get('/friends/{friendId}',function(Request $request, int $friendId){
//     return response()->json([
//         'id' => $friendId,
//         'nickname' => 'ニックネーム',
//         'email' => 'test@example.com',
//         'image_url' => null,
//         'pin' => null,
//     ]);
// });
Route::get('/friends/{friendId}', 'Api\FriendController@show')->name('api.friends.get');


});