<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function can_be_liked(): MorphTo
    {
        return $this->morphTo();
    }
}
