<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';

    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'is_public',
        'type',
        'images',
        'price',
        'slug',
        'quantity',
    ];

    protected $attributes = [
        'images' => '[]',
    ];

    // Auto cast the 'images' attribute to an array
    protected $casts = [
        'images' => 'array',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getFormattedIsPublicAttribute()
    {
        return $this->is_public ? 'Hiển thị' : 'Không hiển thị';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y H:i');
    }

    public function getIsInactiveAttribute()
    {
        return $this->is_public === false;
    }

    public function getIsSaleAttribute()
    {
        return $this->price > 0 && $this->quantity > 0;
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price == 0 ? '0' : number_format($this->price);
    }

    public function getFormattedTypeAttribute()
    {
        if ($this->type == 'fossils') {
            return 'Hóa thạch';
        }

        if ($this->type == 'handicrafts') {
            return 'Đồ thủ công mỹ nghệ';
        }

        if ($this->type == 'painting') {
            return 'Tranh vẽ';
        }

        if ($this->type == 'sculpture') {
            return 'Tác phẩm điêu khắc';
        }

        if ($this->type == 'statues') {
            return 'Tượng';
        }

        return 'Khác';
    }

    public function getImagesJsonAttribute()
    {
        return json_decode($this->images, true);
    }
}
