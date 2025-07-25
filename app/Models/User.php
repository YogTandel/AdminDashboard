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
        'distributor_id',
        'login_status',
        'agent',
        'agent_id',
        'status',
        'original_password',
        'DateOfCreation',
        'endpoint',
        'winamount',
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
        'balance'        => 'integer',
        'winamount'      => 'integer',
        'isupdated'      => 'boolean',
        'login_status'   => 'boolean',
        'DateOfCreation' => 'double',
        'endpoint'       => 'integer',
    ];


    protected function getGameHistoryAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        return json_decode($value, true) ?? [];
    }

    public function getBalanceAttribute($value)
    {
        // change this value amount save in integer
        return (int) (string) $value;
    }

    public function getWinamountAttribute($value)
    {
        return (int) (string) $value;
    }

    public function distributorUser()
    {
        return $this->belongsTo(User::class, 'distributor');
    }

    public function agentUser()
    {
        return $this->belongsTo(User::class, 'agent');
    }
}
