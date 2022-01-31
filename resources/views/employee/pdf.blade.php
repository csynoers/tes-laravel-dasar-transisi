<!DOCTYPE html>
<html>
<head>
    <title>Employees ({{ request('company') ?? 'All' }})</title>
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        
        tr:nth-child(even) {
          background-color: #dddddd;
        }
    </style>
</head>
<body>
    <table style="width: 100%; border: 1px;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->company }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $status[$employee->status] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No employees in company {{ request('company') ?? 'All' }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>