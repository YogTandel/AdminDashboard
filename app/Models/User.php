<?php
namespace App\Models;

use \Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\BSON\Decimal128;
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
        'login_status',
        'agent',
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
        'balance'        => 'double',
        'winamount'      => 'decimal:2',
        'isupdated'      => 'boolean',
        // 'login_status'   => 'boolean',
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
    return $value instanceof Decimal128 ? (float) (string) $value : $value;
}

//     public function isAdmin()
// {
//     return $this->role === 'admin'; // Adjust according to your role field
// }
}
