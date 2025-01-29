<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contest->name }} - Reporte</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 0;
            color: #333;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 24px;
            color: #2C3E50;
        }
        .date {
            font-size: 12px;
            color: #7f8c8d;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
            font-size: 14px;
        }
        td {
            font-size: 12px;
        }
        .total {
            background-color: #f39c12;
            color: white;
            font-weight: bold;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #95a5a6;
        }
    </style>
</head>
<body>
    <header>
        <h1>{{ $contest->name }}</h1>
        <p class="date">Fecha de impresión: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </header>

    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
