<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class GetData implements ToCollection
{
    public $filteredRows;
    protected $categories;

    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    public function collection(Collection $rows)
    {

        $headerRow = $rows->shift();

        if (!$headerRow) {
            throw new \Exception("No headers found in the Excel file.");
        }

        // Preserve header case
        $headers = $headerRow->toArray();


        $rows->filter(function ($row) use ($headers) {
            $rowData = array_combine($headers, $row->toArray());
            if($rowData['Category'] != null) {
                if(in_array($rowData['Category'], $this->categories)) {
                    $this->filteredRows[] = $rowData;
                }
            }
        });

    }

    public function getFilteredRows()
    {
        return $this->filteredRows;
    }
}
