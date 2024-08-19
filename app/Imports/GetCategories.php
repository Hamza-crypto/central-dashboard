<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GetCategories implements ToCollection
{
    public static $categories = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $category = $row[81];
            if(is_null($category)) {
                continue;
            }

            self::$categories[] = $category;
        }

    }
}