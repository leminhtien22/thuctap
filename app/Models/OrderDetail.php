<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'collection_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price);
    }
}
