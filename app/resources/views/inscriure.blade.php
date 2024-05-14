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
    </head>
    <body>
        <p class="h2">Inscripció a {{ $cursa->cur_nom }}</p>
        {{ Form::open(['method' => 'post']) }}
            @csrf
            <div>
                <div>    
                    {{ Form::label('l_nom', 'Nom del participant') }}
                    {{ Form::text('f_nom') }}
                </div>
                <div>    
                    {{ Form::label('l_nom', 'Nom del participant') }}
                    {{ Form::text('f_nom') }}
                </div>
                <div>    
                    {{ Form::label('l_nom', 'Nom del participant') }}
                    {{ Form::text('f_nom') }}
                </div>
                <div>    
                    {{ Form::label('l_nom', 'Nom del participant') }}
                    {{ Form::text('f_nom') }}
                </div>
            </div>
        {{ Form::close() }}
    </body>
</html>
