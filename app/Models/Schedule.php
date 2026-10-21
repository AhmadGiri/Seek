<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $guarded = ['id'];

    public function movie() {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function ticketPrice() {
        return $this->belongsTo(Ticketprice::class, 'ticket_price_id');
    }
}
