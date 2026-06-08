<?php

namespace App\Exports;

use App\Models\Interview;
use Spatie\SimpleExcel\SimpleExcelWriter;

class InterviewsExport
{
    public function download(): \Illuminate\Http\Response
    {
        $path = sys_get_temp_dir() . '/interviews_' . uniqid() . '.xlsx';
        $writer = SimpleExcelWriter::create($path);

        $writer->addRow(['Student', 'Internship', 'Company', 'Date', 'Time', 'Type', 'Status']);

        Interview::with(['application.student.user', 'application.internship.company'])
            ->orderBy('created_at')
            ->chunk(200, function ($rows) use ($writer) {
                foreach ($rows as $iv) {
                    $writer->addRow([
                        $iv->application->student->user->name ?? '—',
                        $iv->application->internship->title ?? '—',
                        $iv->application->internship->company->company_name ?? '—',
                        $iv->interview_date->format('d M Y'),
                        substr($iv->interview_time, 0, 5),
                        $iv->typeLabel(),
                        ucfirst($iv->status),
                    ]);
                }
            });

        $writer->close();

        return response()->download($path, 'interviews.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
