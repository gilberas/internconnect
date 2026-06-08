<?php

namespace App\Exports;

use App\Models\Application;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ApplicationsExport
{
    public function __construct(public string $from, public string $to) {}

    public function download(): \Illuminate\Http\Response
    {
        $path = sys_get_temp_dir() . '/applications_' . uniqid() . '.xlsx';
        $writer = SimpleExcelWriter::create($path);

        $writer->addRow(['Student', 'Email', 'Internship', 'Company', 'Status', 'Applied']);

        Application::with(['internship.company', 'student.user'])
            ->whereBetween('created_at', [$this->from, $this->to])
            ->orderBy('created_at')
            ->chunk(200, function ($rows) use ($writer) {
                foreach ($rows as $app) {
                    $writer->addRow([
                        $app->student->user->name ?? '—',
                        $app->student->user->email ?? '—',
                        $app->internship->title,
                        $app->internship->company->company_name,
                        $app->statusLabel(),
                        $app->created_at->format('d M Y'),
                    ]);
                }
            });

        $writer->close();

        return response()->download($path, 'applications.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
