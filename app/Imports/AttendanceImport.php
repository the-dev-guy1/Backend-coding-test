<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\AppHumanResources\Attendance\Domain\Attendance;
use Carbon\Carbon;

class AttendanceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Convert Excel serialized dates to proper datetime format
        $checkinDateTime = Carbon::createFromTimestamp(($row['checkin'] - 25569) * 86400)->format('Y-m-d H:i:s');
        $checkoutDateTime = Carbon::createFromTimestamp(($row['checkout'] - 25569) * 86400)->format('Y-m-d H:i:s');

        // Create and return a model instance based on the row data
        return new Attendance([
            // Map your Excel columns to the corresponding attributes in the Attendance model
            'employee_id' => $row['employee_id'],
            'schedule_id' => $row['schedule_id'],
            'checkin' => $checkinDateTime,
            'checkout' => $checkoutDateTime,
        ]);
    }
}
