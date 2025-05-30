<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Setting extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'agent_comission',
        'distributor_comission',
        'earning',
        'earning_percentage',
        'set_to_minimum',
        'standing',
        'custom_bet',
        'result',
        'last_10_data',
        'is_negative_agent',
        'agent_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'agent_comission'       => 'decimal:2',
        'distributor_comission' => 'decimal:2',
        'earning'               => 'decimal:2',
        'earning_percentage'    => 'integer',
        'set_to_minimum'        => 'boolean',
        'standing'              => 'decimal:2',
        'custom_bet'            => 'integer',
        'last_10_data'          => 'array',
    ];

    /**
     * Default attribute values
     *
     * @var array
     */
    protected $attributes = [
        'agent_comission'       => 0.0,
        'distributor_comission' => 0.0,
        'earning_percentage'    => 0,
        'set_to_minimum'        => false,
        'custom_bet'            => -1,
        'result'                => '8',
    ];

    /**
     * Get the agent associated with these settings
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
