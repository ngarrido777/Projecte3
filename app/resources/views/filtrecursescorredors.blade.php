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

        .hidden{
            display: none;
        }

        img {
            width: 70px;
        }

        .card-img-top {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div>
    <div class="container mt-4">
        <h1 class="p-3 text-center">Totes les Curses</h1>

        <div class="d-flex justify-content-end mb-4">
            @if ($usu == null)
                {{ Form::open(['url' => '/login', 'method' => 'post', 'class' => 'form-inline']) }}
                    @csrf
                    {{ Form::submit('Login', ['name' => 'f_login', 'class' => 'btn btn-primary']) }}
                {{ Form::close() }}
            @else 
                {{ Form::open(['url' => '/logeout', 'method' => 'post', 'class' => 'form-inline']) }}
                    @csrf
                    {{ Form::submit('Logeout', ['name' => 'f_logeout', 'class' => 'btn btn-danger']) }}
                {{ Form::close() }}
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
        <div class="row">
            @foreach($curses as $cursa)
            <div class="col-md-4">
                <div class="card">
                    <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' class="card-img-top" />                  
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $cursa->cur_nom }}</h5>
                    <p class="card-text"><strong>Data inici: </strong>{{ $cursa->cur_data_inici }}</p>
                    <p class="card-text"><strong>Lloc: </strong>{{ $cursa->cur_lloc }}</p>
                    <p class="card-text"><strong>Descripcció: </strong>{{ $cursa->cur_desc }}</p>
                    <p class="card-text"><strong>Web: </strong>{{ $cursa->cur_web }}</p>
                    {{ Form::open(['url' => '/veurecurses/' . $cursa->cur_id, 'method' => 'post']) }}
                        @csrf
                        <p class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</p>
                        <p class="text-center align-middle">{{ Form::submit('Veure', ['name' => 'f_veure', 'class' => 'btn btn-primary']) }}</p>
                    {{ Form::close() }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>