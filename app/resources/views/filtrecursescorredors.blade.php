<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtre Curses</title>
    <style>
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }

        .hidden {
            display: none;
        }

        img {
            width: 70px;
        }

        .card-title {
            text-transform: uppercase;
            text-shadow: 1px 0 3px white, 0 1px 3px white, -1px 0 3px white, 0 -1px 3px white;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .cursa-data,
        .img-wrapper {
            margin: 0 10px;
        }

        .img-wrapper {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid black;
            margin-bottom: 15px;
        }

        .cursa-card {
            margin: 10px 0;
            padding-top: 10px;
            border: 1px solid black;
            border-radius: 10px;
            overflow: hidden;
        }

        .cursa-card,
        .cursa-card:hover {
            transition: all 0.5s ease;
        }

        .cursa-card:hover {
            transform: translateY(-10px) rotate(1deg);
        }

        /* Oberta */
        .estat2 {
            background: linear-gradient(160deg, #afc, #cfc);
        }

        /* Tancada */
        .estat3 {
            background: linear-gradient(-160deg, #ffa, #efd);
        }

        /* En curs */
        .estat4 {
            background: linear-gradient(-160deg, #adf, #ddf);
        }

        /* Finalitzada */
        .estat5 {
            background: linear-gradient(160deg, #dcf, #dad);
        }

        /* Finalitzada */
        .estat6 {
            background: linear-gradient(160deg, #f98, #f8a);
        }

        .f_desc {
            padding: 0 10px;
            margin: 0;
            height: 100px;
            overflow: hidden;
            left: 0;
            position: relative;
        }   

        .f_desc::after {
            position: absolute;
            content: "";
            width: 100%;
            height: 70px;
            background: linear-gradient(transparent, #111);
            bottom: 0;
            left: 0;
            pointer-events: none;
        }   

        .cursa-veure {
            margin: 0;
        }

        .button-veure {
            margin: 0;
            padding: 20px 0;  
            background-color: #111;
        }

        .a-button {
            border: 1px solid #767676;
            border-radius: 3px;
            padding: 3px 10px;
            background-color: #efefef;
        }

        .not-a {
            color: black;
        }

        .not-a:hover {
            color: black;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div>
    <div class="container mt-4">
        <h1 class="p-3 text-center">Totes les Curses</h1>

        <div class="d-flex justify-content-between flex-row-reverse mb-4">
            @if ($usu == null)
                <a href="/login" class="btn btn-primary">Log in</a>
            @else
                <a href="/logeout" class="btn btn-danger">Log out</a>
                @if ($usu->usr_admin == 1)
                    <a href="/filtrecurses" class="btn btn-info">Vista admin</a>
                @endif
            @endif
        </div>

        <h2 class="p-3">Cerca la cursa</h2>

        {{ Form::open(['url' => '/filtrecursescorredors', 'method' => 'post']) }}
            @csrf
            <div class="form-row p-3">
                <div class="form-group col-md-3">
                    {{ Form::label('l_nom', 'Nom:') }}
                    {{ Form::text('f_nom', $last['l_nom'], ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-md-3">
                    {{ Form::label('l_datainici', 'Data Inici:') }}
                    {{ Form::date('f_data_inici', $last['l_data_inici'], ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-md-3">
                    {{ Form::label('l_esport', 'Esport:') }}
                    {{ Form::select('f_esport', $esports, $last['l_esport'], ['class' => 'form-control']) }}
                </div>
                <div class="form-group col-md-3">
                    {{ Form::label('l_estat', 'Estat:') }}
                    {{ Form::select('f_estat', $estats, $last['l_estat'], ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="d-flex justify-content-end p-3">
                {{ Form::submit('Cercar', ['name' => 'f_cercar', 'class' => 'btn btn-success']) }}
            </div>
        {{ Form::close() }}
        
        <span class="error">{{ $error }}</span>
    </div>

    <div class="container">
        @foreach($curses_totals as $curses)
            <h3>{{ $curses['titol'] }}</h3>
            <div class="row">
                @foreach($curses['curses'] as $cursa)
                <div class="col-md-4 cursa-wrapper">
                    <div class="cursa-card estat{{ $cursa->cur_est_id }}">
                        <div class="img-wrapper">
                            <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' class="card-img-top" />                  
                        </div>
                        <div class="cursa-data">
                            <h5 class="card-title">{{ $cursa->cur_nom }}</h5>
                            <p class="card-text"><strong>Data inici: </strong>{{ $cursa->cur_data_inici }}</p>
                            <p class="card-text"><strong>Lloc: </strong>{{ $cursa->cur_lloc }}</p>
                            <p class="card-text"><strong><a href="{{ $cursa->cur_web }}">Lloc web de {{ $cursa->cur_nom }}</a></strong></p>
                        </div>
                        <div class="cursa-veure">
                            <p class="card-text f_desc"><strong>Descripció: </strong>{{ $cursa->cur_desc }}</p>
                            {{ Form::open(['url' => '/veurecurses/' . $cursa->cur_id, 'method' => 'post']) }}
                                @csrf
                                <p class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</p>
                                <p class="text-center align-middle button-veure">{{ Form::submit('Veure més', ['name' => 'f_veure', 'class' => 'btn btn-primary']) }}</p>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div>
</body>
</html>