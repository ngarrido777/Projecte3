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

        .img_eliminar{
            width: 25px;
            height: 25px;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', f_main);

        function f_main()
        {
            let confirmar_b = document.querySelectorAll('.confirmar');

            confirmar_b.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    let conf = confirm('Segur que vols realitzar aquesta acció ?');
                    if (!conf) {
                        event.preventDefault();
                    }
                });
            });
        }
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div>
        <h1 class="p-3">Totes les Curses</h1>
        @if ($usu == null)
            {{ Form::open(['url' => '/login', 'method' => 'post']) }}
                @csrf
                <td>{{ Form::submit('Login', ['name' => 'f_login']) }}</td>
            {{ Form::close() }}
        @else 
            {{ Form::open(['url' => '/logeout', 'method' => 'post']) }}
                @csrf
                <td>{{ Form::submit('Logeout', ['name' => 'f_logeout']) }}</td>
            {{ Form::close() }}
        @endif
    </div>
    <h2 class="p-3">Cerca la cursa</h2>
    {{ Form::open( ['method' => 'post']) }}
        @csrf
        <div class="d-flex justify-content-around p-3">
            <div>
                {{ Form::label('l_nom', 'Nom/Lloc:') }}
                {{ Form::text('f_nom_lloc', $last['l_nom_lloc']) }}
            </div>
            <div>
                {{ Form::label('l_datainici', 'Data Inici:') }}
                {{ Form::date('f_data_inici', $last['l_data_inici']) }}
            </div>
            <div>
                {{ Form::label('l_estat', 'Estat:') }}
                {{ Form::select('f_estat', $estats, $last['l_estat']) }}
            </div>

            {{ Form::submit('Cercar', ['name' => 'f_cercar']) }}
        </div>
    {{ Form::close() }}
        
    <span class="error">{{ $error }}</span>

    {{ Form::open( ['method' => 'post']) }}
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th scope="col" class="text-center"><img src="{{ asset('img/eliminar.png') }}" class="img_eliminar"></th>
                    <th scope="col" class="text-center">Nom</th>
                    <th scope="col" class="text-center">Tipus</th>
                    <th scope="col" class="text-center">Data Inici</th>
                    <th scope="col" class="text-center">Lloc</th>
                    <th scope="col" class="text-center">Limit</th>
                    <th scope="col" class="text-center">Estat</th>
                    <th scope="col" class="text-center">Veure</th>
                    <th scope="col" class="text-center">Modificar</th>
                    <th scope="col" class="text-center">Obrir inscripció</th>
                    <th scope="col" class="text-center">Tancar inscripcions</th>
                    <th scope="col" class="text-center">En curs</th>
                    <th scope="col" class="text-center">Cancelar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($curses as $cursa)
                    <tr>
                        @if ($cursa->cur_est_id == 1)
                            <td class="text-center align-middle"><input type="checkbox" name="e_ck[]" value="{{ $cursa->cur_id  }}"></td>
                        @else
                            <td class="text-center align-middle"></td>
                        @endif
                        <td class="text-center align-middle">{{ $cursa->cur_nom }}</td>
                        <td class="text-center align-middle">{{ $cursa->esport->esp_nom }}</td>
                        <td class="text-center align-middle">{{ $cursa->cur_data_inici }}</td>
                        <td class="text-center align-middle">{{ $cursa->cur_lloc }}</td>
                        <td class="text-center align-middle">{{ $cursa->cur_limit_inscr }}</td>
                        <td class="text-center align-middle">{{ $cursa->estat->est_nom }}</td>
                        {{ Form::open(['url' => '/veurecursesadmin/' . $cursa->cur_id, 'method' => 'post']) }}
                            @csrf
                            <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                            <td class="text-center align-middle">{{ Form::submit('Veure', ['name' => 'f_veure']) }}</td>
                        {{ Form::close() }}
                        @if ($cursa->cur_est_id == 1)
                            {{ Form::open(['url' => '/updatecurses/' . $cursa->cur_id, 'method' => 'post']) }}
                                @csrf
                                <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                                <td class="text-center align-middle">{{ Form::submit('Modificar', ['name' => 'f_update']) }}</td>
                            {{ Form::close() }}
                            {{ Form::open( ['method' => 'post'] ) }}
                                @csrf
                                <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                                <td class="text-center align-middle">{{ Form::submit('Obrir', ['name' => 'f_oberta', 'class' => 'confirmar']) }}</td>
                            {{ Form::close() }}
                        @else
                            <td class="text-center align-middle"></td>
                            <td class="text-center align-middle"></td>
                        @endif
                        @if ($cursa->cur_est_id == 2)
                            {{ Form::open( ['method' => 'post'] ) }}
                                @csrf
                                <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                                <td class="text-center align-middle">{{ Form::submit('Tancar', ['name' => 'f_tancada', 'class' => 'confirmar']) }}</td>
                            {{ Form::close() }}
                        @else
                            <td class="text-center align-middle"></td>
                        @endif
                        @if ($cursa->cur_est_id == 3)
                            {{ Form::open( ['method' => 'post'] ) }}
                                @csrf
                                <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                                <td class="text-center align-middle">{{ Form::submit('Iniciar', ['name' => 'f_iniciar', 'class' => 'confirmar']) }}</td>
                            {{ Form::close() }}
                        @else
                            <td class="text-center align-middle"></td>
                        @endif
                        @if ($cursa->cur_est_id == 2 || $cursa->cur_est_id == 3 || $cursa->cur_est_id == 4)
                            {{ Form::open( ['method' => 'post'] ) }}
                                @csrf
                                <td class="hidden">{{ Form::text('up_cur_id', $cursa->cur_id) }}</td>
                                <td class="text-center align-middle">{{ Form::submit('Cancelar', ['name' => 'f_cancelada', 'class' => 'confirmar']) }}</td>
                            {{ Form::close() }}
                        @else
                            <td class="text-center align-middle"></td>
                            <td class="text-center align-middle"></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ Form::submit('Eliminar', ['name' => 'f_elimina']) }}
    {{ Form::close() }}
</body>
</html>