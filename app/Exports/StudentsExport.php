<?php

namespace App\Exports;

use App\Models\User;
use Spatie\SimpleExcel\SimpleExcelWriter;

class StudentsExport
{
    public function __construct(public string $from, public string $to) {}

    public function download(): \Illuminate\Http\Response
    {
        $path = sys_get_temp_dir() . '/students_' . uniqid() . '.xlsx';
        $writer = SimpleExcelWriter::create($path);

        $writer->addRow(['Name', 'Email', 'Registered']);

        User::where('account_type', 'student')
            ->whereBetween('created_at', [$this->from, $this->to])
            ->orderBy('created_at')
            ->chunk(200, function ($rows) use ($writer) {
                foreach ($rows as $u) {
                    $writer->addRow([
                        $u->name,
                        $u->email,
                        $u->created_at->format('d M Y'),
                    ]);
                }
            });

        $writer->close();

        return response()->download($path, 'students.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
