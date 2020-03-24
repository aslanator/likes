<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class News
 * @package App
 * @property int $id
 * @property string $name
 * @property string $datetime
 * @property string $slug
 * @property string $text
 */
class News extends Model
{
    protected $fillable = [
        'name', 'datetime', 'slug', 'text',
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
