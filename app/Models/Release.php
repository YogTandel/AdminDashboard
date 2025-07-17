<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Release extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'releases';

    protected $fillable = [
        'transfer_to',
        'type',
        'total_bet',
        'commission_percentage',
        'remaining_balance',
        'transfer_role',
    ];
}
