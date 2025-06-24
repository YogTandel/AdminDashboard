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
        'earning',
        'earningPercentage',
        'setTominimum',
        'standing',
        'customBet',
        'result',
        'last10data',
        'is_nagative_agent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'agentComission'       => 'decimal:2',
        'distributorComission' => 'decimal:2',
        'earning'              => 'decimal:2',
        'earningPercentage'    => 'integer',
        'setTominimum'         => 'boolean',
        'standing'             => 'decimal:2',
        'customBet'            => 'integer',
        'last10data'           => 'array',
    ];

    /**
     * Default attribute values
     *
     * @var array
     */
    protected $attributes = [
        'agentComission'       => 0.0,
        'distributorComission' => 0.0,
        'earningPercentage'    => 0,
        'setTominimum'         => false,
        'customBet'            => -1,
        'result'               => '8',
    ];

    /**
     * Get the agent associated with these settings
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
