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
    <div>
        <h1 class="p-3">Totes les Curses</h1>
        @if ($usu == null)
            {{ Form::open(['url' => '/login', 'method' => 'post']) }}
                @csrf
                <td>{{ Form::submit('Login', ['name' => 'f_login']) }}</td>
            {{ Form::close() }}
        @else 
            {{ Form::open(['url' => '/logeout', 'method' => 'post']) }}
                @csrf
                <td>{{ Form::submit('Logeout', ['name' => 'f_logeout']) }}</td>
            {{ Form::close() }}
        @endif
    </div>
    <h2 class="p-3">Cerca la cursa</h2>
    {{ Form::open( ['method' => 'post']) }}
        @csrf
        <div class="d-flex justify-content-around p-3">
            <div>
                {{ Form::label('l_nom', 'Nom/Lloc:') }}
                {{ Form::text('f_nom_lloc', $last['l_nom_lloc']) }}
            </div>
            <div>
                {{ Form::label('l_datainici', 'Data Inici:') }}
                {{ Form::date('f_data_inici', $last['l_data_inici']) }}
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
                <th scope="col" class="text-center">Nom</th>
                <th scope="col" class="text-center">Tipus</th>
                <th scope="col" class="text-center">Data Inici</th>
                <th scope="col" class="text-center">Lloc</th>
                <th scope="col" class="text-center">Circuits</th>
                <th scope="col" class="text-center">Distàncies</th>
                <th scope="col" class="text-center">Inscrits</th>
                <th scope="col" class="text-center">Limit</th>
                <th scope="col" class="text-center">Estat</th>
                <th scope="col" class="text-center">Veure</th>
                <th scope="col" class="text-center">Modificar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($curses as $cursa)
                <tr>
                    <td class="text-center align-middle">{{ $cursa->cur_nom }}</td>
                    <td class="text-center align-middle">{{ $cursa->esport->esp_nom }}</td>
                    <td class="text-center align-middle">{{ $cursa->cur_data_inici }}</td>
                    <td class="text-center align-middle">{{ $cursa->cur_lloc }}</td>
                    <td class="text-center align-middle"></td>
                    <td class="text-center align-middle"></td>
                    <td class="text-center align-middle"></td>
                    <td class="text-center align-middle">{{ $cursa->cur_limit_inscr }}</td>
                    <td class="text-center align-middle">{{ $cursa->estat->est_nom }}</td>
                    {{ Form::open(['url' => '/veurecurses/' . $cursa->cur_id, 'method' => 'post']) }}
                        @csrf
                        <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                        <td class="text-center align-middle">{{ Form::submit('Veure', ['name' => 'f_veure']) }}</td>
                    {{ Form::close() }}
                    {{ Form::open(['url' => '/updatecurses/' . $cursa->cur_id, 'method' => 'post']) }}
                        @csrf
                        <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                        <td class="text-center align-middle">{{ Form::submit('Modificar', ['name' => 'f_update']) }}</td>
                    {{ Form::close() }}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>