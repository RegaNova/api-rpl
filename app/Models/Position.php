<?php

namespace App\Models;

use App\Traits\HasFormattedTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, HasUuids, HasFormattedTimestamps;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
    ];
}
