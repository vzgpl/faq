<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reader extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'readers';

    protected $fillable = [
        'name',
        'login',
        'password',
        'token',
        'remember_token',
    ];

    protected $hidden = [
        'token',
        'remember_token',
        'password',
    ];
}
