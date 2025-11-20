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
        'agentComission',
        'distributorComission',
        'earning' => 'float',
        'earningPercentage',
        'setTominimum',
        'standing',
        'customBet',
        'result',
        'last10data',
        'is_nagative_agent',
        'holding'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'agentComission' => 'integer',
        'distributorComission' => 'integer',
        'earning' => 'integer',
        'earningPercentage' => 'Double',
        'setTominimum' => 'boolean',
        'standing' => 'integer',
        'holding' => 'integer',
        'customBet' => 'integer',
        'last10data' => 'array',
    ];

    /**
     * Default attribute values
     *
     * @var array
     */
    protected $attributes = [
        'agentComission' => 0,
        'distributorComission' => 0,
        'earningPercentage' => 0,
        'setTominimum' => false,
        'customBet' => -1,
        'result' => '8',
    ];

    /**
     * Get the agent associated with these settings
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
