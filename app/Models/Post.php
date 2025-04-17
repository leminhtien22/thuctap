<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'thumbnail',
        'slug',
        'content_html',
        'content_text',
        'status',
        'view_count',
        'user_id',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->locale('vi_VN')->format('H:i:s, d-m-Y');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->locale('vi_VN')->format('H:i:s, d-m-Y');
    }

    public function getFormattedDeletedAtAttribute()
    {
        return Carbon::parse($this->deleted_at)->locale('vi_VN')->format('H:i:s, d-m-Y');
    }

    public function getFormattedStatusAttribute()
    {
        return $this->status == 'active' ? 'Hiển thị' : 'Không hiển thị';
    }

    public function getIsInactiveAttribute()
    {
        return $this->status == 'inactive';
    }
}
