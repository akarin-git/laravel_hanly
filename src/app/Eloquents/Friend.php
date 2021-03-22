<?php

namespace App\Eloquents;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

// class Friend extends Model
class Friend extends Authenticatable
{
    // authトークン
    use HasApiTokens;

    // 実際のテーブルが、クラス名の複数形＋スネークケースであれば、書かなくてOK
    protected $table = 'friends';

    // Eloquentを通して更新や登録が可能なフィールド（ホワイトリストを定義）
    protected $fillable = [
        'nickname', 'email', 'password', 'image_path'
    ];

    // 変更できない&jsonレスポンスに含まない
    protected $hidden = [
        'password','remember_token',
    ];

    /**
     * @param int $friendId
     * @return self|null
     */
    public function findById(int $friendId): ?self
    {
        return $this->newInstance()
            ->with(['pin'])
            ->find($friendId);

    }

    /**
     * @param array $friendIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByIds(array $friendIds): Collection
    {
        return $this->newInstance()
            ->with(['pin'])
            ->whereIn('id', $friendIds)
            ->get();
    }

    /**
     * @param int $myId
     * @param array $myFriendIds
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function notFriendsWithPin(int $myId, array $myFriendIds): Collection
    {
        return $this->newInstance()
            ->with(['pin'])
            ->where('id', '<>', $myId)
            ->whereNotIn('id', $myFriendIds)
            ->whereHas('pin', function ($query) {
                $query->where('created_at', '>=', now()->subMinutes(self::SEARCH_LIMIT_MINUTES));
            })
            ->get();
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $nickname
     * @return self
     */
    public function store(string $email, string $password, string $nickname): self
    {
        return $this->newInstance()
            ->create([
                'email' => $email,
                'password' => bcrypt($password),
                'nickname' => $nickname,
            ]);
    }

    /**
     * @param int $myId
     * @param string $path
     * @return bool
     */
    public function imageStore(int $myId, string $path): bool
    {
        return $this->newInstance()
            ->find($myId)
            ->fill([
                'image_path' => $path,
            ])
            ->save();
    }


    public function relationship()
    {
        return $this->hasMany(\App\Eloquents\Friendrelation::class,'own_friends_id','id');
    }

    public function pin()
    {
        return $this->hasOne(\App\Eloquents\Pin::class,'friends_id','id');
    }
}
