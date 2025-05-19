<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'transaction_report';

    protected $fillable = [
        'amount',
        'from',
        'to',
    ];
}
