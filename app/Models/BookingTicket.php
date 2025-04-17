<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingTicket extends Model
{
    protected $table = 'booking_tickets';

    protected $fillable = [
        'exhibition_id',
        'user_id',
        'ticket_count',
        'total_price',
        'is_paid',
        'details',
    ];

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', false);
    }

    public function scopeByExhibition($query, $exhibitionId)
    {
        return $query->where('exhibition_id', $exhibitionId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
