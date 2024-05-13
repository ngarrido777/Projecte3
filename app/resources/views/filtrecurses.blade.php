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

        img {
            width: 70px;
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
                <th scope="col" class="text-center">Image</th>
                <th scope="col" class="text-center">Nom</th>
                <th scope="col" class="text-center">Data Inici</th>
                <th scope="col" class="text-center">Data Fi</th>
                <th scope="col" class="text-center">Lloc</th>
                <th scope="col" class="text-center">Esport</th>
                <th scope="col" class="text-center">Estat</th>
                <th scope="col" class="text-center">Limit</th>
                <th scope="col" class="text-center">Modificar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($curses as $cursa)
                <tr>
                    <td class="text-center align-middle"><img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' /></td>
                    <td class="text-center align-middle">{{ $cursa->cur_nom }}</td>
                    <td class="text-center align-middle">{{ $cursa->cur_data_inici }}</td>
                    <td class="text-center align-middle">{{ $cursa->cur_data_fi }}</td>
                    <td class="text-center align-middle">{{ $cursa->cur_lloc }}</td>
                    <td class="text-center align-middle">{{ $cursa->esport->esp_nom }}</td>
                    <td class="text-center align-middle">{{ $cursa->estat->est_nom }}</td>
                    <td class="text-center align-middle">{{ $cursa->cur_limit_inscr }}</td>
                    {{ Form::open(['url' => '/updatecurses/' . $cursa->cur_id, 'method' => 'post']) }}
                        @csrf
                        <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                        <td class="text-center align-middle">{{ Form::submit('Modificar', ['name' => 'f_update']) }}</td>
                    {{ Form::close() }}
                </tr>
            @endforeach
            @foreach($bea as $b)
                <tr>
                    <td class="text-center align-middle">{{ $b->bea_id }}</td>
                    <td class="text-center align-middle">{{ $b->bea_code }}</td>
                </tr>   
            @endforeach
        </tbody>

    </table>
</body>
</html>
