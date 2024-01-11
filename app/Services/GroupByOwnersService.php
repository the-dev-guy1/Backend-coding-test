<?php
namespace App\Services;

use App\Models\Company;

class GroupByOwnersService
{
    public function groupByOwners(): array
    {
        $companies = Company::with('files')->get();

        $result = [];

        foreach ($companies as $company) {
            $result[$company->name] = $company->files->pluck('name')->toArray();
        }

        return $result;
    }
}
