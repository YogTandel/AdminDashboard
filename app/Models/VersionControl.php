<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class VersionControl extends Model
{
    protected $connection = 'mongodb';

    protected string $collection = 'version_controls';

    protected $fillable = [
        'version',
        'enabled',
    ];

    protected $casts = [
        'version' => 'string',
        'enabled' => 'boolean',
    ];
}
