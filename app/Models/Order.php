<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'total_quantity',
        'notes',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return $this->total_price == 0 ? '0' : number_format($this->total_price) . ' đ';
    }

    public function getFormattedCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->locale('vi_VN')->format('H:i:s, d-m-Y');
    }

    public function getFormattedIsPaidAttribute()
    {
        return $this->is_paid == 0 ? 'Chưa thanh toán' : 'Đã thanh toán';
    }
}
