<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class FileHelper
{
    public function exportExcel(array $data, array $headers, string $filename = 'export.xlsx')
    {
        $export = new class($data, $headers) implements FromArray, WithHeadings {
            protected $data;
            protected $headers;

            public function __construct($data, $headers)
            {
                $this->data = $data;
                $this->headers = $headers;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headers;
            }
        };

        return Excel::download($export, $filename);
    }

    public function exportPdf(string $view, array $data, string $filename = 'export.pdf')
    {
        $pdf = Pdf::loadView($view, $data);
        return $pdf->download($filename);
    }

    public function importExcel($file, callable $callback)
    {
        $data = Excel::toArray([], $file)[0];
        foreach ($data as $row) {
            $callback($row);
        }
    }
}
