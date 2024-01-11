<?php

namespace App\AppHumanResources\Attendance\Domain;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances'; // Specify the table name if it's different from the default

    protected $fillable = [
        'employee_id',
        'schedule_id',
        'checkin',
        'checkout',
        // Add other fillable properties as needed
    ];
}
