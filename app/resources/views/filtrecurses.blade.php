<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtre Curses</title>
    <style>
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }

        .hidden{
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="p-3">Totes les Curses</h1>
    <h2 class="p-3">Cerca la cursa</h2>
    {{ Form::open(['url' => '/', 'method' => 'post']) }}
        @csrf
        <div class="d-flex justify-content-around p-3">
            <div>    
                {{ Form::label('l_nom', 'Nom:') }}
                {{ Form::text('f_nom', $last['l_nom']) }}
            </div>
            <div>
                {{ Form::label('l_datainici', 'Data Inici:') }}
                {{ Form::date('f_data_inici', $last['l_data_inici']) }}
            </div>
            <div>
                {{ Form::label('l_esport', 'Esport:') }}
                {{ Form::select('f_esport', $esports, $last['l_esport']) }}
            </div>
            <div>
                {{ Form::label('l_estat', 'Estat:') }}
                {{ Form::select('f_estat', $estats, $last['l_estat']) }}
            </div>

            {{ Form::submit('Cercar', ['name' => 'f_cercar']) }}
        </div>
    {{ Form::close() }}
        
    <span class="error">{{ $error }}</span>

    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Data Inici</th>
                <th scope="col">Data Fi</th>
                <th scope="col">Lloc</th>
                <th scope="col">Esport</th>
                <th scope="col">Estat</th>
                <th scope="col">Limit</th>
                <th scope="col">Modificar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($curses as $cursa)
                <tr>
                    <td>{{ $cursa->cur_nom }}</td>
                    <td>{{ $cursa->cur_data_inici }}</td>
                    <td>{{ $cursa->cur_data_fi }}</td>
                    <td>{{ $cursa->cur_lloc }}</td>
                    <td>{{ $cursa->esport->esp_nom }}</td>
                    <td>{{ $cursa->estat->est_nom }}</td>
                    <td>{{ $cursa->cur_limit_inscr }}</td>
                    {{ Form::open(['url' => '/updatecurses', 'method' => 'post']) }}
                        @csrf
                        <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                        <td>{{ Form::submit('Modificar', ['name' => 'f_update']) }}</td>
                    {{ Form::close() }}
                </tr>
            @endforeach
        </tbody>

    </table>
</body>
</html>
