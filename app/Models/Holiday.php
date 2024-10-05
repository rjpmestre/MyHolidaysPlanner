<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\HolidayType;

class Holiday extends Model
{
    public $timestamps = true;
    use SoftDeletes;
    use HasFactory;
    protected $table = 'holidays';

    protected $fillable = [
        'date',
        'type_id',
        'description',
        'group_id'
    ];

    public function type()
    {
        return $this->belongsTo(HolidayType::class, 'type_id')->withTrashed();
    }

}
