<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
  h1 { color: #059669; border-bottom: 2px solid #059669; padding-bottom: 6px; margin-bottom: 4px; }
  .meta { color: #666; font-size: 11px; margin-bottom: 16px; }
  table { width: 100%; border-collapse: collapse; margin-top: 8px; }
  th { background: #059669; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
  td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
  tr:nth-child(even) td { background: #ecfdf5; }
  .badge-verified { color: #059669; font-weight: bold; }
  .badge-pending  { color: #d97706; }
  .badge-rejected { color: #dc2626; }
  .footer { margin-top: 24px; font-size: 10px; color: #9ca3af; text-align: center; }
</style>
</head>
<body>
<h1>{{ $title }}</h1>
<p class="meta">
  Generated: {{ now()->format('d M Y H:i') }} &nbsp;|&nbsp;
  Total: {{ $rows->count() }}
</p>
<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Company Name</th>
      <th>Reg Number</th>
      <th>Contact</th>
      <th>Phone</th>
      <th>Status</th>
      <th>Registered</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $i => $c)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $c->company_name }}</td>
      <td>{{ $c->registration_number }}</td>
      <td>{{ $c->contact_person ?? '—' }}</td>
      <td>{{ $c->phone ?? '—' }}</td>
      <td class="badge-{{ $c->verification_status }}">{{ ucfirst($c->verification_status) }}</td>
      <td>{{ $c->created_at->format('d M Y') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<p class="footer">InternConnect &mdash; Confidential Report</p>
</body>
</html>
