<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Holiday;

class HolidayType extends Model
{
    public $timestamps = true;
    use SoftDeletes;
    use HasFactory;
    protected $table = 'holiday_types';

    protected $fillable = ['name'];

    public function holidays()
    {
        return $this->hasMany(Holiday::class, 'type_id')->whereNull('holidays.deleted_at');
    }
}
