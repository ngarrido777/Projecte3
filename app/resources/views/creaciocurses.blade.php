<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacio Curses</title>
    <style>
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="p-3">Creació de les Curses</h1>
    {{ Form::open(['url' => 'creaciocurses', 'method' => 'post', 'files' => true]) }}
        @csrf
        {{ Form::label('l_nom', 'Nom:') }}
        {{ Form::text('c_nom', $ultims_camps['l_nom']) }}
        {{ Form::label(null, $errors['e_nom'], ['class' => 'error']) }}

        {{ Form::label('l_data_inici', 'Data Inici:') }}
        {{ Form::date('c_data_inici', $ultims_camps['l_data_inici']) }}
        {{ Form::label(null, $errors['e_data_inici'], ['class' => 'error']) }}
        
        {{ Form::label('l_data_fi', 'Data Fi:') }}
        {{ Form::date('c_data_fi', $ultims_camps['l_data_fi']) }}
        {{ Form::label(null, $errors['e_data_fi'], ['class' => 'error']) }}

        {{ Form::label('l_lloc', 'Lloc:') }}
        {{ Form::text('c_lloc', $ultims_camps['l_lloc']) }}
        {{ Form::label(null, $errors['e_lloc'], ['class' => 'error']) }}

        {{ Form::label('l_esport', 'Esport:') }}
        {{ Form::select('c_esport', $esports, $ultims_camps['l_esport']) }}
        {{ Form::label(null, $errors['e_esport'], ['class' => 'error']) }}

        {{ Form::label('l_descripccio', '*Descripccio:') }}
        {{ Form::text('c_descripccio', $ultims_camps['l_descripccio']) }}
        {{ Form::label(null, $errors['e_descripcio'], ['class' => 'error']) }}

        {{ Form::label('l_limit', 'Limit:') }}
        {{ Form::text('c_limit', $ultims_camps['l_limit']) }}
        {{ Form::label(null, $errors['e_limit'], ['class' => 'error']) }}

        {{ Form::label('l_foto', 'Foto:') }}
        {{ Form::file('c_foto', ['accept' => '.png , .jpg']) }}
        {{ Form::label(null, $errors['e_foto'], ['class' => 'error']) }}
        
        {{ Form::label('l_web', '*Web:') }}
        {{ Form::text('c_web', $ultims_camps['l_web']) }}
        {{ Form::label(null, $errors['e_web'], ['class' => 'error']) }}

        {{ Form::submit('Crear', ['name' => 'c_crear']) }}

        @if($ok)
           {{ Form::label('l_creada', 'Cursa creada correctament !') }}
        @endif

    {{ Form::close() }}
</body>
</html>