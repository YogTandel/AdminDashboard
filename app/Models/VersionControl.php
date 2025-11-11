<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VersionControl extends Model
{
    protected $connection = 'mongodb';

    protected string $collection = 'version_controls';

    protected $fillable = [
        'version',
        'code',
        'url',
        'enabled',
    ];

    protected $casts = [
        'version' => 'string',
        'code' => 'string',
        'url' => 'string',
        'enabled' => 'boolean',
    ];
}
