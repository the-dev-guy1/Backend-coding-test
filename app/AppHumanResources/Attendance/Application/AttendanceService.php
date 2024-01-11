<?php
// app/AppHumanResources/Attendance/Application/AttendanceService.php

namespace App\AppHumanResources\Attendance\Application;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\AppHumanResources\Attendance\Domain\Attendance;
use App\Imports\AttendanceImport;

class AttendanceService implements WithHeadingRow
{
    public function processExcelAttendance($excelFile)
    {
        try {
            // Load the Excel file into a collection
            $importedData = Excel::import(new AttendanceImport(), $excelFile);


            // Assuming the Excel file has columns like 'employee_id', 'schedule_id', 'checkin', 'checkout'

            // Loop through each row of the Excel data and save to the database
            foreach ($importedData as $row) {
                Attendance::create([
                    'employee_id' => $row['employee_id'],
                    'schedule_id' => $row['schedule_id'],
                    'checkin' => $row['checkin'],
                    'checkout' => $row['checkout'],
                    // Add other columns as needed
                ]);
            }

            return ['message' => 'Excel attendance processed successfully'];
        } catch (\Exception $e) {
            // Handle exceptions (e.g., invalid Excel format, database errors)
            return ['error' => 'Error processing Excel attendance: ' . $e->getMessage()];
        }
    }

    public function getAllEmployeeAttendance()
{
    $employeeAttendanceData = DB::table('employees')
        ->leftJoin('attendances', 'employees.id', '=', 'attendances.employee_id')
        ->select(
            'employees.first_name',
            'employees.last_name',
            'attendances.checkin',
            'attendances.checkout',
            DB::raw('IFNULL(TIMEDIFF(attendances.checkout, attendances.checkin), "N/A") as working_hours')
        )
        ->get();

    return $employeeAttendanceData;
}

}
