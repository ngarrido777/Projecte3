<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacio Curses</title>
</head>
<body>
    <h1>Creacció de les Curses</h1>
    {{ Form::open(array('url' => 'creaciocurses', 'method' => 'post')) }}
        @csrf
        {{ Form::label('l_nom', 'Nom:') }}
        {{ Form::text('c_nom') }}
        <br>
        <br>
        {{ Form::label('l_data_inici', 'Data Inici:') }}
        {{ Form::date('c_data_inici') }}
        <br>
        <br>
        {{ Form::label('l_data_fi', 'Data Fi:') }}
        {{ Form::date('c_data_fi') }}
        <br>
        <br>
        {{ Form::label('l_lloc', 'Lloc:') }}
        {{ Form::text('c_lloc') }}
        <br>
        <br>
        {{ Form::label('l_esport', 'Esport:') }}
        {{ Form::select('c_esport', [
            
            ]) }}
        <br>
        <br>
        {{ Form::label('l_estat', 'Estat:') }}
        <select>

        </select>
        <br>
        <br>
        <input type="button" name="c_cursa" value="Crear" />
    {{ Form::close() }}
</body>
</html>