<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veure cursa admin</title>
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
    <h1 class="p-4 text-center">Veure Cursa</h1>
    <div class="caixa">
        <div>
            <div>
                {{ Form::label('l_nom', 'Nom:') }}
                <p class='salt'>{{$cursa->cur_nom}}</p>
            </div>
            <div>
                {{ Form::label('l_datainici', 'Tipus:') }}
                <p class='salt'>{{$cursa->esport->esp_nom}}</p>
            </div>
            <div>
                {{ Form::label('l_datainici', 'Data Inici:') }}
                <p class='salt'>{{$cursa->cur_data_inici}}</p>
            </div>
            <div>
                {{ Form::label('l_datafi', 'Data Fi:') }}
                <p class='salt'>{{$cursa->cur_data_fi}}</p>
            </div>
            <div>
                {{ Form::label('l_lloc', 'Lloc:') }}
                <p class='salt'>{{$cursa->cur_lloc}}</p>
            </div>
            <div>
                {{ Form::label('l_cir', 'Número circuits:') }}
                <p class='salt'>{{$n_cir}}</p>
            </div>
            <div>
                {{ Form::label('l_dist', 'Distancies:') }}
                @foreach($dist as $d)
                    <p class='salt'>{{$d->cir_distancia}}m</p>
                @endforeach
            </div>
            <div>
                {{ Form::label('l_n_ins', 'Número inscrits:') }}
                <p class='salt'>{{$nins}}</p>
            </div>
            <div>
                {{ Form::label('l_limit', 'Limit:') }}
                <p class='salt'>{{$cursa->cur_limit_inscr}}</p>
            </div>
            <div>
                {{ Form::label('l_estat', 'Estat:') }}
                <p class='salt'>{{$cursa->estat->est_nom}}</p>
            </div>
            <div>
                @if ($cursa->cur_est_id == 2)
                    <a href="/inscriure/{{$cursa->cur_id}}" clasS="btn btn-success">Inscriute</a>
                @endif

                @if ($cursa->cur_est_id == 4)
                    <a href="/asignarparticipant/{{$cursa->cur_id}}" clasS="btn btn-success">Recepció</a> 
                @endif

                @if ($cursa->cur_est_id == 4 || $cursa->cur_est_id == 5)
                    <a href="/resultats/{{$cursa->cur_id}}" clasS="btn btn-success">Veure resultats</a> 
                @endif
                <a href="/filtrecurses" clasS="btn btn-primary">Torna</a>
            </div>
        </div>
        <div>
            <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' />
        </div>
    </div>
</body>
</html>