<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cronograma</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2>Cronograma</h2>
    <table>
        <thead>
            <tr>
                <th>Tarefa</th>
                <th>Início</th>
                <th>Duração</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedule as $item)
                <tr>
                    <td>{{ $item['title'] }}</td>
                    <td>{{ $item['start_time'] }}</td>
                    <td>{{ $item['duration'] }} min</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
