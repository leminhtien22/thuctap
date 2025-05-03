<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tour_type')->default('private');
            $table->dateTime('booking_date');
            $table->integer('number_of_people');
            $table->string('status')->default('pending');
            $table->decimal('total_price', 8, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tour_bookings');
    }
}