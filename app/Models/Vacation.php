<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    public $timestamps = true;
    use HasFactory;
    protected $table = 'vacations';

    protected $fillable = [
        'date',
    ];
}
