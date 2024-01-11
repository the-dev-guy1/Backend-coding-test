<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GroupByOwnersService;

class GroupByOwnersController extends Controller
{
    public function groupByOwners(GroupByOwnersService $groupByOwnersService)
    {
        $result = $groupByOwnersService->groupByOwners();

        return response()->json($result);
    }
}
