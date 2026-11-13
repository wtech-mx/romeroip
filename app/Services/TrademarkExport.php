<?php
namespace App\Services;

use App\Support\ResultsColumns;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TrademarkExport
{
    public function templates(): array
    {
        // A stored style template. Management/upload UI will be added separately.
        $template = json_decode(file_get_contents(resource_path('export-templates/kept-standard.json')), true, 512, JSON_THROW_ON_ERROR);
        return [$template['id'] => $template];
    }

    public function download(Collection $records, string $format, ?string $templateId = null)
    {
        $template = $this->templates()[$templateId ?: 'kept-standard'];
        if ($format === 'template') $format = 'xlsx';
        $columns = array_diff_key(ResultsColumns::definitions(), array_flip(['select', 'edit']));
        $rows = $records->map(fn ($record) => array_map(fn ($key) => ResultsColumns::value($record, $key), array_keys($columns)))->all();
        $headers = array_column($columns, 'label');
        $path = tempnam(sys_get_temp_dir(), 'kept-export-');
        try {
            match ($format) {
                'xlsx' => $this->xlsx($path, $records, $columns, $rows, $template),
                'csv' => $this->csv($path, $headers, $rows),
                'docx' => $this->docx($path, $headers, $rows),
                'pdf' => $this->pdf($path, $headers, $rows),
            };
        } catch (\Throwable $error) { @unlink($path); throw $error; }
        $mime = ['xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'csv' => 'text/csv; charset=UTF-8',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'pdf' => 'application/pdf'][$format];
        return response()->download($path, 'trademarks.'.$format, ['Content-Type' => $mime])->deleteFileAfterSend(true);
    }

    private function xlsx(string $path, Collection $records, array $columns, array $rows, array $template): void
    {
        $book = new Spreadsheet();
        $book->getProperties()->setCreator('kept')->setTitle('Trademarks');
        $book->getDefaultStyle()->getFont()->setName($template['font'])->setSize($template['font_size']);
        $sheet = $book->getActiveSheet(); $sheet->setTitle('trademarks');
        $sheet->getSheetView()->setZoomScale($template['zoom']); $sheet->freezePane('A2');
        $last = Coordinate::stringFromColumnIndex(count($columns));
        $end = count($rows) + 1;
        $range = 'A1:'.$last.$end;
        $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB('FF000000');
        $sheet->getStyle('A1:'.$last.'1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF'.$template['header_fill']);
        $sheet->getStyle('A1:'.$last.'1')->getFont()->setBold(true);
        $sheet->getRowDimension(1)->setRowHeight($template['header_height']);
        $columnKeys = array_keys($columns);
        foreach ($columnKeys as $i => $key) {
            $letter = Coordinate::stringFromColumnIndex($i + 1);
            $sheet->getColumnDimension($letter)->setWidth($template['widths'][$key] ?? 20);
            $sheet->setCellValueExplicit($letter.'1', $columns[$key]['label'], DataType::TYPE_STRING);
        }
        foreach ($rows as $i => $values) {
            $number = $i + 2; $lines = 1;
            foreach ($values as $j => $value) {
                $key = $columnKeys[$j]; $cell = Coordinate::stringFromColumnIndex($j + 1).$number;
                // Store references as text, preserving leading zeros and preventing formula execution.
                $sheet->setCellValueExplicit($cell, $value, DataType::TYPE_STRING);
                if (($columns[$key]['type'] ?? '') === 'date') {
                    $raw = ResultsColumns::value($records[$i], $key, false);
                    if ($raw && preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) {
                        $sheet->setCellValue($cell, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(new \DateTimeImmutable($raw)));
                        $sheet->getStyle($cell)->getNumberFormat()->setFormatCode('[$-en-US]mmm/dd/yyyy');
                    }
                }
                $width = $template['widths'][$key] ?? 20;
                $lineCount = array_sum(array_map(fn ($line) => max(1, (int) ceil(mb_strlen($line) / max(1, $width - 2))), explode("\n", str_replace("\r", '', $value))));
                $lines = max($lines, $lineCount);
            }
            $sheet->getRowDimension($number)->setRowHeight(max($template['row_height'], $lines * 13 + 8));
        }
        $sheet->setAutoFilter('A1:'.$last.$end);
        $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 1);
        (new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($book))->save($path);
        $book->disconnectWorksheets();
    }

    private function csv(string $path, array $headers, array $rows): void
    {
        $file = fopen($path, 'wb'); fwrite($file, "\xEF\xBB\xBF");
        foreach (array_merge([$headers], $rows) as $row) {
            fputcsv($file, array_map(fn ($value) => preg_match('/^[=+\-@\t\r]/u', $value) ? "'".$value : $value, $row), ',', '"', '');
        }
        fclose($file);
    }

    private function docx(string $path, array $headers, array $rows): void
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $word = new \PhpOffice\PhpWord\PhpWord(); $word->setDefaultFontName('Arial'); $word->setDefaultFontSize(10);
        $section = $word->addSection(['marginTop' => 700, 'marginBottom' => 700]);
        foreach ($rows as $i => $values) {
            if ($i) $section->addPageBreak();
            $section->addText('Trademarks · '.$values[0], ['bold' => true, 'size' => 16]);
            $table = $section->addTable(['borderSize' => 4, 'borderColor' => 'D8DAE3', 'cellMargin' => 90]);
            foreach ($headers as $j => $header) {
                $table->addRow();
                $table->addCell(2800, ['bgColor' => 'F3F3F6', 'valign' => 'center'])->addText($header, ['bold' => true]);
                $cell = $table->addCell(6200, ['valign' => 'center']);
                foreach (preg_split('/\R/u', $values[$j] ?: '—') as $line) $cell->addText($line);
            }
        }
        \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007')->save($path);
    }

    private function pdf(string $path, array $headers, array $rows): void
    {
        $escape = fn ($value) => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $html = '<html><meta charset="utf-8"><style>@page{margin:30px}body{font-family:DejaVu Sans;font-size:10px;color:#252630}h1{font-size:18px}table{width:100%;border-collapse:collapse;table-layout:fixed}td,th{border:1px solid #ddd;padding:7px;word-wrap:break-word}th{background:#f3f3f6;width:30%;text-align:left}tr{page-break-inside:avoid}.record{page-break-before:always}.record:first-child{page-break-before:auto}</style><body>';
        foreach ($rows as $values) {
            $html .= '<div class="record"><h1>Trademarks · '.$escape($values[0]).'</h1><table>';
            foreach ($headers as $j => $header) $html .= '<tr><th>'.$escape($header).'</th><td>'.nl2br($escape($values[$j] ?: '—')).'</td></tr>';
            $html .= '</table></div>';
        }
        $pdf = new \Dompdf\Dompdf(['isRemoteEnabled' => false, 'isPhpEnabled' => false]);
        $pdf->loadHtml($html.'</body></html>', 'UTF-8'); $pdf->setPaper('A4'); $pdf->render();
        file_put_contents($path, $pdf->output());
    }
}
