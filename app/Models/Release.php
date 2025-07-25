<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Release extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'releases';

    protected $fillable = [
        'transfer_to',
        'name',
        'type',
        'total_bet',
        'commission_percentage',
        'commission_amount',
        'remaining_balance',
        'transfer_role',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'total_bet'             => 'integer',
        'remaining_balance'     => 'integer',
        'commission_percentage' => 'double',
    ];
}
