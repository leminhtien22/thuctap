<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourBooking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tour_type', 'booking_date', 'number_of_people', 'status', 'total_price', 'notes'];
}