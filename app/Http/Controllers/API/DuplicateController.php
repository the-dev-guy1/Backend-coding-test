<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DuplicateController extends Controller
{
    public function findDuplicates()
    {
        $N = request('N');
        $a = request('a');

        $frequencyMap = [];
        $result = [];

        // Traverse the array and count the frequency of each element
        for ($i = 0; $i < $N; $i++) {
            $element = $a[$i];
            if (isset($frequencyMap[$element])) {
                // If element is already in the frequency map, increment its count
                $frequencyMap[$element]++;
            } else {
                // If element is not in the frequency map, add it with count 1
                $frequencyMap[$element] = 1;
            }
        }

        // Check for elements with frequency greater than 1
        foreach ($frequencyMap as $element => $count) {
            if ($count > 1) {
                $result[] = $element;
            }
        }

        return response()->json(['duplicates' => $result]);
    }
}
