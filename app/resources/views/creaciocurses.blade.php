<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacio >Curses</title>
</head>
<body>
    <h1>Creacció de les Curses</h1>
    {{ Form::open(array('url' => 'foo/bar', 'method' => 'post')) }}
        <label name="l_nom">Nom:</label>
        <input type="text" name="c_nom" />
        <label name="l_data_inici">Data Inici:</label>
        <input type="date" name="c_data_inici" />
        <label name="l_data_fi">Data Fi:</label>
        <input type="date" name="c_data_fi" />
        <label name="l_lloc">Lloc:</label>
        <input type="button" name="c_cursa" />
    {{ Form::close() }}
</body>
</html>