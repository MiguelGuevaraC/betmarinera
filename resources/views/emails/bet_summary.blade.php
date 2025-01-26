<!DOCTYPE html>
<html>

<head>
    <title>Resumen de tus Apuestas</title>
</head>

<body>
    <h1>Resumen de Apuestas para el Concurso: {{ $contest->name }}</h1>

    <p>Estimado(a) {{ Auth::user()->name }},</p>

    <p>A continuación, se encuentra un resumen de las apuestas que has realizado en el concurso:</p>

    <table border="1">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Apuesta Realizada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userBets as $bet)
                <tr>
                    <td>{{ $bet->category->name }}</td>
                    <td>{{ $bet->contestant->names }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Gracias por participar. ¡Buena suerte!</p>
</body>

</html>
