<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacio Curses</title>
    <style>
        .form-element {
            display: block;
            margin-bottom: 20px;
        }
    </style>

</head>
<body>
    <h1>Creacció de les Curses</h1>
    {{ Form::open(['url' => 'creaciocurses', 'method' => 'post']) }}
        @csrf
        {{ Form::label('l_nom', 'Nom:') }}
        {{ Form::text('c_nom', null, ['class' => 'form-element form-text']) }}

        {{ Form::label('l_data_inici', 'Data Inici:') }}
        {{ Form::date('c_data_inici', null, ['class' => 'form-element form-text']) }}
        
        {{ Form::label('l_data_fi', 'Data Fi:') }}
        {{ Form::date('c_data_fi', null, ['class' => 'form-element form-text']) }}

        {{ Form::label('l_lloc', 'Lloc:') }}
        {{ Form::text('c_lloc', null, ['class' => 'form-element form-text']) }}

        {{ Form::label('l_esport', 'Esport:') }}
        {{ Form::select('c_esport', $esports, null, ['class' => 'form-element form-text']) }}

        {{ Form::submit('Crear', ['name' => 'c_crear']) }}
    {{ Form::close() }}
</body>
</html>