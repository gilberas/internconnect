<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
  h1 { color: #4f46e5; border-bottom: 2px solid #4f46e5; padding-bottom: 6px; margin-bottom: 4px; }
  .meta { color: #666; font-size: 11px; margin-bottom: 16px; }
  table { width: 100%; border-collapse: collapse; margin-top: 8px; }
  th { background: #4f46e5; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
  td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
  tr:nth-child(even) td { background: #eef2ff; }
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
      <th>Title</th>
      <th>Company</th>
      <th>Category</th>
      <th>Location</th>
      <th>Positions</th>
      <th>Deadline</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $i => $item)
    <tr>
      <td>{{ $i + 1 }}</td>
      <td>{{ $item->title }}</td>
      <td>{{ $item->company->company_name }}</td>
      <td>{{ $item->category->name }}</td>
      <td>{{ $item->location }}</td>
      <td>{{ $item->positions }}</td>
      <td>{{ $item->deadline->format('d M Y') }}</td>
      <td>{{ ucfirst($item->status) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<p class="footer">InternConnect &mdash; Confidential Report</p>
</body>
</html>
