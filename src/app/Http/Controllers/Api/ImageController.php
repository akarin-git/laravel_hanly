<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\Friend;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ImageStoreRequest;
// use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $friend;

    public function __construct(Friend $friend)
    {
      $this->friend = $friend;  
    }

    /**
     * @param \App\Http\Requests\Api\ImageStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageStoreRequest $request)
    {
        $myId = \DB::transaction(function () use ($request){
            // Tokenから自分のIDを取得
            $myId = $request->user()->id;
            
            // 保存場所はstorage/app/images/のした
            $savedPath = $request->file->store('images','local');
            
            // DBにパスを保存しておく
            Friend::find($myId)
            ->fill([
                'image_path' => $savedPath,
                ])
                ->save();
                // dd($savedPath);
                
                return $myId;
            });
            
        return response()->json([
            'image_url' => route('web.image.get',['friendId' => $myId])
        ]);
    }
}
