<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
  h1 { color: #7c3aed; border-bottom: 2px solid #7c3aed; padding-bottom: 6px; margin-bottom: 4px; }
  .meta { color: #666; font-size: 11px; margin-bottom: 16px; }
  table { width: 100%; border-collapse: collapse; margin-top: 8px; }
  th { background: #7c3aed; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
  td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
  tr:nth-child(even) td { background: #f5f3ff; }
  .footer { margin-top: 24px; font-size: 10px; color: #9ca3af; text-align: center; }
</style>
</head>
<body>
<h1>{{ $title }}</h1>
<p class="meta">
  Period: {{ $from }} to {{ $to }} &nbsp;|&nbsp;
  Generated: {{ now()->format('d M Y H:i') }} &nbsp;|&nbsp;
  Total: {{ $rows->count() }}
</p>
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Student</th>
      <th>Internship</th>
      <th>Company</th>
      <th>Status</th>
      <th>Applied</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $i => $app)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $app->student->user->name ?? '—' }}</td>
      <td>{{ $app->internship->title }}</td>
      <td>{{ $app->internship->company->company_name ?? '—' }}</td>
      <td>{{ $app->statusLabel() }}</td>
      <td>{{ $app->created_at->format('d M Y') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<p class="footer">InternConnect &mdash; Confidential Report</p>
</body>
</html>
