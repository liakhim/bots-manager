<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUpdates extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'update_id',
        'data',
        'data_type',
        'date'
    ];
}
