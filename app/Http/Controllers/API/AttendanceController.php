<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AppHumanResources\Attendance\Application\AttendanceService;
use App\AppHumanResources\Attendance\Domain\Attendance;
use Illuminate\Support\Facades\Validator;


class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        try {
            $employeeAttendanceData = $this->attendanceService->getAllEmployeeAttendance();

            return response()->json(['success' => true, 'data' => $employeeAttendanceData], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function uploadAttendanceExcel(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|mimes:xlsx,xls|max:2048', // Adjust max file size if needed
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Process the Excel file using the AttendanceService
        $result = $this->attendanceService->processExcelAttendance($request->file('excel_file'));

        // Return a response based on the result
        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        return response()->json(['message' => 'Excel attendance uploaded successfully']);
    }
}
