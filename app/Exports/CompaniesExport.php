<?php

namespace App\Exports;

use App\Models\CompanyProfile;
use Spatie\SimpleExcel\SimpleExcelWriter;

class CompaniesExport
{
    public function download(): \Illuminate\Http\Response
    {
        $path = sys_get_temp_dir() . '/companies_' . uniqid() . '.xlsx';
        $writer = SimpleExcelWriter::create($path);

        $writer->addRow(['Company', 'Reg Number', 'Phone', 'Status', 'Registered']);

        CompanyProfile::with('user')
            ->orderBy('created_at')
            ->chunk(200, function ($rows) use ($writer) {
                foreach ($rows as $c) {
                    $writer->addRow([
                        $c->company_name,
                        $c->registration_number,
                        $c->phone ?? '—',
                        ucfirst($c->verification_status),
                        $c->created_at->format('d M Y'),
                    ]);
                }
            });

        $writer->close();

        return response()->download($path, 'companies.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}
