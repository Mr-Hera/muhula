<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>

<h2>Dashboard Report</h2>
<p>Date: {{ now()->format('d M Y') }}</p>

<table>
    <thead>
        <tr>
            <th>Metric</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Total Schools</td><td>{{ $totalSchools }}</td></tr>
        <tr><td>Total Reviews</td><td>{{ $totalReviews }}</td></tr>
        <tr><td>Unread Messages</td><td>{{ $unreadMessages }}</td></tr>
    </tbody>
</table>

</body>
</html>
