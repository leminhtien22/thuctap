<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'post_id', 'viewed_at'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

