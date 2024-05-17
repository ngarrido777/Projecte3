<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veure cursa</title>
    <style>
        img{
            width: 500px;
            height: 500px;
        }
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }
        .salt {
            display: block;
            margin-bottom: 20px;
        }
        .caixa{
            display: flex;
            justify-content: space-around;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="p-4 text-center">VeureCursa</h1>
    <div class="caixa">
        <div>
            <div>
                {{ Form::label('l_nom', 'Nom:') }}
                {{ Form::label('c_nom', $cursa->cur_nom, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_datainici', 'Data Inici:') }}
                {{ Form::label('c_data_inici', $cursa->cur_data_inici, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_datafi', 'Data Fi:') }}
                {{ Form::label('c_data_fi', $cursa->cur_data_fi, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_lloc', 'Lloc:') }}
                {{ Form::label('c_lloc', $cursa->cur_lloc, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_esport', 'Esport:') }}
                {{ Form::label('c_esport', $cursa->esport->esp_nom, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_estat', 'Estat:') }}
                {{ Form::label('c_esport', $cursa->estat->est_nom, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_descripcio', 'Descripció:') }}
                {{ Form::label('c_descripccio', $cursa->cur_desc, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_limit', 'Limit:') }}
                {{ Form::label('c_limit', $cursa->cur_limit_inscr, ['class' => 'salt']) }}
            </div>
            <div>
                {{ Form::label('l_web', 'Web:') }}
                {{ Form::label('c_web', $cursa->cur_web, ['class' => 'salt']) }}
            </div>
        </div>
        <div>
            <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' />
        </div>
    </div>
</body>
</html>
