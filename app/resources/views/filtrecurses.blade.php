<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtre Curses</title>
</head>
<body>
    <h1>Totes les Curses</h1>
    <h2>Carca la cursa</h2>
    {{ Form::open(['url' => '/', 'method' => 'post']) }}
        @csrf
        {{ Form::label('l_nom', 'Nom:') }}
        {{ Form::text('f_nom') }}

        {{ Form::label('l_datainici', 'Data Inici:') }}
        {{ Form::date('f_data_inici') }}

        {{ Form::label('l_esport', 'Esport:') }}
        {{ Form::select('f_esport', $esports) }}

        {{ Form::label('l_estat', 'Estat:') }}
        {{ Form::select('f_estat', $estats) }}

        {{ Form::submit('Cercar', ['name' => 'f_cercar']) }}
    {{ Form::close() }}

    <table>
        <tbody>
            <tr>
                <th>Nom</th>
                <th>Data Inici</th>
                <th>Data Fi</th>
                <th>Lloc</th>
                <th>Esport</th>
                <th>Estat</th>
                <th>Limit</th>
            </tr>
            @foreach($curses as $cursa)
                <tr>
                    <td>{{ $cursa->cur_nom }}</td>
                    <td>{{ $cursa->cur_data_inici }}</td>
                    <td>{{ $cursa->cur_data_fi }}</td>
                    <td>{{ $cursa->cur_lloc }}</td>
                    <td>{{ $cursa->esport->esp_nom }}</td>
                    <td>{{ $cursa->estat->est_nom }}</td>
                    <td>{{ $cursa->cur_limit_inscr }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</body>
</html>
