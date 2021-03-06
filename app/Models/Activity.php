<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use Uuids, HasFactory;

    protected $fillable = [
        'content',
        'tags',
        'user_id'
    ];
}
