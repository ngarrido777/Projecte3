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

</head>
<body>
    <h1>Creacció de les Curses</h1>
    {{ Form::open(['url' => 'creaciocurses', 'method' => 'post']) }}
        @csrf
        {{ Form::label('l_nom', 'Nom:') }}
        {{ Form::text('c_nom', null) }}
        {{ Form::label(null, $errors['e_nom'], ['class' => 'error']) }}

        {{ Form::label('l_data_inici', 'Data Inici:') }}
        {{ Form::date('c_data_inici', null) }}
        {{ Form::label(null, $errors['e_data_inici'], ['class' => 'error']) }}
        
        {{ Form::label('l_data_fi', 'Data Fi:') }}
        {{ Form::date('c_data_fi', null) }}
        {{ Form::label(null, $errors['e_data_fi'], ['class' => 'error']) }}

        {{ Form::label('l_lloc', 'Lloc:') }}
        {{ Form::text('c_lloc', null) }}
        {{ Form::label(null, $errors['e_lloc'], ['class' => 'error']) }}

        {{ Form::label('l_esport', 'Esport:') }}
        {{ Form::select('c_esport', $esports, null) }}
        {{ Form::label(null, $errors['e_esport'], ['class' => 'error']) }}

        {{ Form::label('l_descripccio', 'Descripccio:') }}
        {{ Form::text('c_descripccio', null) }}
        {{ Form::label(null, $errors['e_descripcio'], ['class' => 'error']) }}

        {{ Form::label('l_limit', 'Limit:') }}
        {{ Form::text('c_limit', null) }}
        {{ Form::label(null, $errors['e_limit'], ['class' => 'error']) }}

        {{ Form::label('l_foto', 'Foto:') }}
        {{ Form::file('c_foto', null) }}
        {{ Form::label(null, $errors['e_foto'], ['class' => 'error']) }}
        
        {{ Form::label('l_web', 'Web:') }}
        {{ Form::text('c_web', null) }}
        {{ Form::label(null, $errors['e_web'], ['class' => 'error']) }}

        {{ Form::submit('Crear', ['name' => 'c_crear']) }}
    {{ Form::close() }}
</body>
</html>