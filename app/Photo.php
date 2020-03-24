<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Photo
 * @package App
 * @property int    $id
 * @property string $url
 * @property string $datetime
 */
class Photo extends Model
{
    protected $fillable = [
        'url', 'datetime',
    ];


    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function likes()
    {
        return $this->morphMany(Like::class, 'can_be_liked');
    }

    public function likedByCurrentUser()
    {
        $user = Auth::user();
        return $this->morphMany(Like::class, 'can_be_liked')->where('user_id', '=', $user->id);
    }
}
