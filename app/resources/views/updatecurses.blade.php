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
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }
        .caixa{
            display: flex;
            justify-content: space-around;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="p-4 text-center">Actualitzar Cursa</h1>
    {{ Form::open(['url' => 'updatecurses/' . $cursa->cur_id, 'method' => 'post', 'files' => true]) }}
        @csrf
        <div class="caixa">
            <div>
                <div>
                    {{ Form::label('l_nom', 'Nom:') }}
                    {{ Form::text('c_nom', $cursa->cur_nom) }}
                    {{ Form::label(null, $errors['e_nom'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_datainici', 'Data Inici:') }}
                    {{ Form::date('c_data_inici', $cursa->cur_data_inici) }}
                    {{ Form::label(null, $errors['e_data_inici'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_datafi', 'Data Fi:') }}
                    {{ Form::date('c_data_fi', $cursa->cur_data_fi) }}
                    {{ Form::label(null, $errors['e_data_fi'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_lloc', 'Lloc:') }}
                    {{ Form::text('c_lloc', $cursa->cur_lloc) }}
                    {{ Form::label(null, $errors['e_lloc'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_esport', 'Esport:') }}
                    {{ Form::select('c_esport', $esports, $cursa->esport->esp_nom) }}
                    {{ Form::label(null, $errors['e_esport'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_estat', 'Estat:') }}
                    {{ Form::select('c_esport', $estats, $cursa->estat->est_nom) }}
                    {{ Form::label(null, $errors['e_estat'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_descripcio', 'Descripció:') }}
                    {{ Form::text('c_descripccio', $cursa->cur_desc) }}
                    {{ Form::label(null, $errors['e_descripcio'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_limit', 'Limit:') }}
                    {{ Form::text('c_limit', $cursa->cur_limit_inscr) }}
                    {{ Form::label(null, $errors['e_limit'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_foto', 'Foto:') }}
                    {{ Form::file('c_foto', ['accept' => '.png , .jpg']) }}
                    {{ Form::label(null, $errors['e_foto'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::label('l_web', 'Web:') }}
                    {{ Form::text('c_web', $cursa->cur_web) }}
                    {{ Form::label(null, $errors['e_web'], ['class' => 'error']) }}
                </div>
                <div>
                    {{ Form::submit('Actualitzar', ['name' => 'c_update']) }}
                </div>
            </div>
            <div>
                <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' />
            </div>
        </div>
    {{ Form::close() }}
</body>
</html>
