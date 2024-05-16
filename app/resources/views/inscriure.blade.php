<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscripció a {{ $cursa->cur_nom }}</title>
        <link rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
        <style>
            
            .msg_inf,
            .msg_adv,
            .msg_err {
                font-weight: bold;
            }

            .msg_inf {
                color: lime;
            }

            .msg_adv {
                color: yellow;
            }

            .msg_err {
                color: red;
            }

        </style>
    </head>
    <body>
        <div>
            <p class="h2">Inscripció a {{ $cursa->cur_nom }}</p>

            @if (!is_null($message))
                <p class="{{ $message['type'] }}">{{ $message['text'] }}</p>
            @endif
            
            <div>
                <img src='data:image/jpeg;charset=utf-8;base64, {{ $cursa->cur_foto }}' />
            </div>
        </div>
        {{ Form::open(['method' => 'post']) }}
            @csrf
            <div>
                <div>    
                    {{ Form::label('l_nom', 'Nom') }}
                    {{ Form::text('f_nom') }}
                </div>
                <div>    
                    {{ Form::label('l_nom', 'Cognoms') }}
                    {{ Form::text('f_cognom') }}
                </div>
                <div>    
                    {{ Form::label('l_dni', 'DNI') }}
                    {{ Form::text('f_dni') }}
                </div>
                <div>    
                    {{ Form::label('l_telefon', 'Teléfon') }}
                    {{ Form::text('f_telefon') }}
                </div>
            </div>
        {{ Form::close() }}
    </body>
</html>
