<?php

namespace App\Http\Controllers;

use App\Property;
use App\SearchProfile;


class SearchController extends Controller
{

    public function deviate($num, $inc = false)
    {
        if ($inc) {
            return (int)((0.25 * $num) + $num);
        }
        return (int)($num - (0.25 * $num));
    }

    public function getPropertyMatches(Property $property)
    {

        /* 
            ALGORITHM:
            1. Loop through total searchProfile
                2. Foreach Loop searchField
                    3. Check if property value is not null
                        4. Check if Keys matches 
                            5. Check if Values matches
                                6. If searchField is in property
                                    7. Add to strict
                                8. If searchField is in property with DEVIATION VALUES
                                    9. Add to loose
            10. Sort the values according to Score.
        */

        // Get all searches where searchFields are NOT NULL
        $data = SearchProfile::query()->where('propertyType', '=', $property->propertyType)->where('searchFields', '!=', null)->get(['id', 'searchFields']);


        $res = array();
        $score = 0;
        $strict = 0;
        $loose = 0;
        for ($i = 0; $i < count($data); $i++) { // Loop through total searchProfile
            foreach ($data[$i]->searchFields as $search_keys => $search_values) { // Foreach Loop searchField
                foreach ($property->fields as $property_keys => $property_values) { // Loop through property fields
                    if ($property_values) { // If property value is not null
                        if ($property_keys === $search_keys) { // Check if Keys matches
                            $search_values[0] = $search_values[0] ? (int)$search_values[0] : 0; // Check if value of first index of array is not null, if null then convert to 0
                            $search_values[1] = $search_values[1] ? (int)$search_values[1] : 0; // Check if value of second index of array  is not null, if null then convert to 0
                            $property_values = (int)$property_values; // Convert property value to integer
                            if ($property_values >= $search_values[0] || $property_values <= $search_values[1]) { // Checking for STRICT MATCH
                                $score += 1;
                                $strict += 1;
                            } else if ($property_values >= $this->deviate($search_values[0], false) || $property_values <= $this->deviate($search_values[1], true)) { // Checking for LOOSE (DEVIATION) MATCH
                                $score += 1;
                                $loose += 1;
                            }
                        }
                    }
                }
            }
            array_push($res, array(
                "searchProfileId" => $data[$i]->id,
                "score" => $score,
                "strictMatchesCount" => $strict,
                "looseMatchesCount" => $loose
            ));
            $score = 0;
            $strict = 0;
            $loose = 0;
        }

        // Sorting result based on SCORE
        usort(
            $res,
            fn (array $a, array $b): int => $b['score'] <=> $a['score']
        );

        return $res;
    }
}
