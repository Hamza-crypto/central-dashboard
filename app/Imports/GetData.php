<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GetData implements ToCollection, WithHeadingRow
{
    public $filteredRows;
    protected $categories;

    // Accept an array of categories in the constructor
    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    public function collection(Collection $rows)
    {
        // Filter rows where the 'category' column matches any of the selected categories
        $this->filteredRows = $rows->filter(function ($row) {
            return in_array($row['category'], $this->categories); // Use 'category' header name
        });
    }

    public function getFilteredRows()
    {
        return $this->filteredRows;
    }
}