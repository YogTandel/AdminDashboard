<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bets';

    protected $fillable = ['player_id', 'agent_id', 'bet'];

    protected $casts = [
        'bet' => 'array',
    ];
}
