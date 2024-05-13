<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update cursa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="p-3">Actualitzar Cursa</h1>
    <label>Nom:</label>
    <label>{{ $cursa->cur_nom }}</lavel>

    <label>Data Inici:</label>
    <label>{{ $cursa->cur_data_inici }}</lavel>

    <label>Data Fi:</label>
    <label>{{ $cursa->cur_data_fi }}</lavel>
    
    <label>Lloc:</label>
    <label>{{ $cursa->cur_lloc }}</lavel>

    <label>Esport:</label>
    <label></label>

    <label>Estat:</label>
    <label></label>

    <label>Imatge:</label>
    <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' />
</body>
</html>
