<?php
namespace App\Models;

use \Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable, HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'player',
        'password',
        'role',
        'balance',
        'distributor',
        'agent',
        'status',
        'original_password',
        'DateOfCreation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password'       => 'hashed',
        'gameHistory'    => 'array',
        'balance'        => 'decimal:2',
        'winamount'      => 'decimal:2',
        'isupdated'      => 'boolean',
        'login_status'   => 'boolean',
        'DateOfCreation' => 'integer',
    ];
}
