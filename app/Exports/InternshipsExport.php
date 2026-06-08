<?php

namespace App\Exports;

use App\Models\Internship;
use Spatie\SimpleExcel\SimpleExcelWriter;

class InternshipsExport
{
    public function download(): \Illuminate\Http\Response
    {
        $path = sys_get_temp_dir() . '/internships_' . uniqid() . '.xlsx';
        $writer = SimpleExcelWriter::create($path);

        $writer->addRow(['Title', 'Company', 'Category', 'Location', 'Type', 'Positions', 'Deadline', 'Status', 'Posted']);

        Internship::with(['company', 'category'])
            ->orderBy('created_at')
            ->chunk(200, function ($rows) use ($writer) {
                foreach ($rows as $i) {
                    $writer->addRow([
                        $i->title,
                        $i->company->company_name,
                        $i->category->name,
                        $i->location,
                        $i->typeLabel(),
                        $i->positions,
                        $i->deadline->format('d M Y'),
                        ucfirst($i->status),
                        $i->created_at->format('d M Y'),
                    ]);
                }
            });

        $writer->close();

        return response()->download($path, 'internships.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
