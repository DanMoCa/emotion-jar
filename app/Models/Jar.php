<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jar extends Model
{
    use Uuids, HasFactory;

    protected $fillable = ['name','user_id'];
}
