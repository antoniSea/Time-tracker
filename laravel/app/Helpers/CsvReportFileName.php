<?php

namespace App\Helpers;

class CsvReportFileName
{
    public function generateCsvReportFileName(string $name): string
    {
        return 'raport-godzinowy-dla-' . $name . '.csv';
    }
}
