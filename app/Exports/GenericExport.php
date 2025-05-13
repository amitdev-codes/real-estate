<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GenericExport implements FromCollection, ShouldAutoSize, WithColumnWidths, WithCustomStartCell, WithDrawings, WithHeadings, WithStyles
{
    protected $records;
    protected $minWidth = 15;
    protected $maxWidth = 60;
    protected $exportType;
    protected $defaultImage;
    protected $imageColumnWidth =14;
    protected $imageRowHeight = 40;

    public function __construct($records, $exportType = null)
    {
        $this->records = $records;
        $this->exportType = $exportType;
        $this->defaultImage = public_path('static/images/bg/01.jpg');
    }

    public function collection()
    {
        return collect($this->records)->map(function ($record) {
            if (isset($record['image'])) {
                switch ($this->exportType['type']) {
                    case 'pdf':
                        $record['image'] = str_repeat(' ', 20);
                        break;
                    case 'csv':
                        // For CSV, convert image to URL or path
                        $record['image'] = $this->getImageUrl($record['image']);
                        break;
                    case 'excel':
                        // For Excel, leave the image field empty as we'll handle it with drawings
                        $record['image'] = '';
                        break;
                }
            }
            return $record;
        });
    }
    protected function getImageUrl($image)
    {
        if (empty($image)) {
            return config('app.url') . '/static/images/bg/01.jpg';
        }

        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        if (strpos($image, '<img') !== false) {
            preg_match('/src=["\'](.+?)["\']/', $image, $matches);
            return $matches[1] ?? config('app.url') . '/static/images/bg/01.jpg';
        }

        return config('app.url') . '/' . ltrim($image, '/');
    }
    protected function formatHeading($heading)
    {
        $formatted = preg_replace('/([a-z])([A-Z])/', '$1 $2', $heading);
        $formatted = str_replace('_', ' ', $formatted);
        return ucwords($formatted);
    }

    public function headings(): array
    {
        if (empty($this->records)) {
            return [];
        }
        return array_map([$this, 'formatHeading'], array_keys($this->records[0]));
    }
    public function drawings()
    {
        if ($this->exportType['type'] === 'csv') {
            return [];
        }

        $drawings = [];
        $row = 2;

        foreach ($this->records as $record) {
            if (!isset($record['image'])) {
                continue;
            }

            $drawing = new Drawing;

            try {
                $imagePath = $this->resolveImagePath($record['image']);

                if (file_exists($imagePath)) {
                    $drawing->setPath($imagePath);
                } else {
                    $drawing->setPath($this->defaultImage);
                }

                $drawing->setHeight($this->exportType['type'] === 'pdf' ? 80 : 80);
                $drawing->setWidth($this->exportType['type'] === 'pdf' ? 80 : 80);
                $drawing->setCoordinates('A' . $row);
                $drawing->setOffsetX(5);
                $drawing->setOffsetY(5);
                $drawing->setResizeProportional(true);

                $drawings[] = $drawing;
            } catch (\Exception $e) {
                \Log::error('Image export error: ' . $e->getMessage());
                $drawing->setPath($this->defaultImage);
                $drawing->setHeight(50);
                $drawing->setWidth(50);
                $drawing->setCoordinates('A' . $row);
                $drawings[] = $drawing;
            }

            $row++;
        }

        return $drawings;
    }

    protected function resolveImagePath($imageString)
    {
        if (empty($imageString)) {
            return $this->defaultImage;
        }

        // Handle different image path formats
        $possiblePaths = [
            $imageString,
            public_path($imageString),
            storage_path('app/public/' . $imageString),
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // Handle URLs
        if (filter_var($imageString, FILTER_VALIDATE_URL)) {
            $path = str_replace(
                [config('app.url'), 'http://localhost:8000', 'http://127.0.0.1:8000'],
                public_path(),
                $imageString
            );
            if (file_exists($path)) {
                return $path;
            }
        }

        // Handle HTML img tags
        if (strpos($imageString, '<img') !== false) {
            preg_match('/src=["\'](.+?)["\']/', $imageString, $matches);
            if (isset($matches[1])) {
                return $this->resolveImagePath($matches[1]);
            }
        }

        return $this->defaultImage;
    }

    public function columnWidths(): array
    {
        if (empty($this->records)) {
            return [];
        }

        $columns = array_keys($this->records[0]);
        $widths = [];

        foreach ($columns as $index => $column) {
            $letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);

            if ($letter === 'A' && isset($this->exportType['type']) && $this->exportType['type'] === 'pdf') {
                // Set wider column for images in PDF
                $widths[$letter] = $this->imageColumnWidth;
            } else {
                $widths[$letter] = $this->calculateColumnWidth($column);
            }
        }

        return $widths;
    }

    protected function calculateColumnWidth($columnData): int
    {
        $maxLength = max(array_map(function ($row) use ($columnData) {
            $value = $row[$columnData] ?? '';
            return strlen(strip_tags((string) $value));
        }, $this->records));

        $width = $maxLength + 5;
        return min(max($width, $this->minWidth), $this->maxWidth);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $lastColumn = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();
        // Set row heights based on export type
        if ($this->exportType['type'] === 'pdf') {
            for ($row = 2; $row <= $lastRow; $row++) {
                $sheet->getRowDimension($row)->setRowHeight($this->imageRowHeight);
            }
        } elseif ($this->exportType['type'] === 'excel') {
            for ($row = 2; $row <= $lastRow; $row++) {
                $sheet->getRowDimension($row)->setRowHeight(50);
            }
        } else {
            $sheet->getDefaultRowDimension()->setRowHeight(40);
        }

        // Disable auto-size for PDF
        if ($this->exportType['type'] === 'pdf') {
            foreach ($sheet->getColumnDimensions() as $column) {
                $column->setAutoSize(false);
            }
        }

        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E4E4E4'],
                ],
            ],
            'A1:' . $lastColumn . $lastRow => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    public function startCell(): string
    {
        return 'A1';
    }
}
