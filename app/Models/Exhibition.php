<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exhibition extends Model
{
    use SoftDeletes;

    protected $table = 'exhibitions';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'status',
        'is_limited_tickets',
        'total_tickets',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'deleted_at',
    ];

    public function tickets()
    {
        return $this->hasMany(BookingTicket::class);
    }

    public function getAvailableTicketsAttribute()
    {
        return $this->is_limited_tickets ? $this->total_tickets - $this->tickets()->sum('ticket_count') : 0;
    }

    public function getIsExpiredAttribute()
    {
        return now()->gt($this->end_date);
    }

    public function getIsUpcomingAttribute()
    {
        return now()->lt($this->start_date);
    }

    public function getIsOngoingAttribute()
    {
        return now()->gte($this->start_date) && now()->lte($this->end_date);
    }

    public function getIsInactiveAttribute()
    {
        return $this->status === 'inactive';
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, ',', '.');
    }

    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->start_date)->format('d/m/Y H:i');
    }

    public function getFormattedEndDateAttribute()
    {
        return Carbon::parse($this->end_date)->format('d/m/Y H:i');
    }
}
