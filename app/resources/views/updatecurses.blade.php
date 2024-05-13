<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update cursa</title>
    <style>
        img{
            width: 500px;
            height: 500px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="p-3">Actualitzar Cursa</h1>
    {{ Form::open(['url' => '/', 'method' => 'post']) }}
        @csrf
        <div>
            {{ Form::label('l_nom', 'Nom:') }}
            <label>{{ $cursa->cur_nom }}</lavel>
        </div>
        <div>
            {{ Form::label('l_datainici', 'Data Inici:') }}
            <label>{{ $cursa->cur_data_inici }}</lavel>
        </div>
        <div>
            {{ Form::label('l_datafi', 'Data Fi:') }}
            <label>{{ $cursa->cur_data_fi }}</lavel>
        </div>
        <div>
            {{ Form::label('l_lloc', 'Lloc:') }}
            <label>{{ $cursa->cur_lloc }}</lavel>
        </div>
        <div>
            {{ Form::label('l_esport', 'Esport:') }}
            <label>{{ $cursa->esport->esp_nom }}</label>
        </div>
        <div>
            {{ Form::label('l_estat', 'Estat:') }}
            <label>{{ $cursa->estat->est_nom }}</label>
        </div>
        <div>
            {{ Form::label('l_descripcio', 'Descripció:') }}
            <label>{{ $cursa->cur_desc }}</label>
        </div>
        <div>
            {{ Form::label('l_limit', 'Limit:') }}
            <label>{{ $cursa->cur_limit_inscr }}</label>
        </div>
        <div>
            {{ Form::label('l_web', 'Web:') }}
            <label>{{ $cursa->cur_web }}</label>
        </div>
        <div>
            <label>Imatge:</label>
            <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' />
        </div>
    {{ Form::close() }}
</body>
</html>
