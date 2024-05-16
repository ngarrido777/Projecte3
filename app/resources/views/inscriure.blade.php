<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscripció a {{ $data['cursa']->cur_nom }}</title>
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

            .hidden {
                display: none;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                const checkbox = document.getElementById('ckb_federat')
                let f_block = document.getElementById('num_federat_block')
    
                checkbox.addEventListener('change', (event) => {
                    if (event.currentTarget.checked) {
                        f_block.classList.remove('hidden');
                    } else {
                        f_block.classList.add('hidden');
                    }
                })

                const ddl_cats = document.getElementById('f_categoria')
                let ddl_cirs = document.getElementById('f_circuit')
                ddl_cats.addEventListener('change', (event) => {
                    ddl_cirs.disabled = false;
                    ddl_cirs.options[0].text = "Escoje el circuito!";
                })
            });
        </script>
    </head>
    <body>
        <div>
            <p class="h2">Inscripció a {{ $data['cursa']->cur_nom }}</p>

            @if (!is_null($message))
                <p class="{{ $message['type'] }}">{{ $message['text'] }}</p>
            @endif
            
            <div>
                <img src="data:image/jpeg;charset=utf-8;base64, {{ $data['cursa']->cur_foto }}" />
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
                    {{ Form::label('l_cognom', 'Cognoms') }}
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
                <div>
                    {{ Form::label('l_email', 'Teléfon') }}
                    {{ Form::text('f_email') }}
                </div>
                <div>
                    {{ Form::label('l_federat', 'Ets federat?') }}
                    {{ Form::checkbox('f_federat', null, false, array('id'=>'ckb_federat')) }}
                    <span id="num_federat_block" class="hidden">
                        {{ Form::label('l_num_federat', 'Num federat') }}
                        {{ Form::text('f_num_federat') }}
                    </span>
                </div>
                <div>
                    {{ Form::label('l_categorias', 'Categorias (desplegable)') }}
                    <select id="f_categoria" name="f_categoria">
                        <option selected disabled value="-1">Escoge tu categoría</option>
                        @foreach ($data['cats'] as $cat)
                            <option value="{{ $cat->cat_id }}">{{ $cat->cat_nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    {{ Form::label('l_circuits', 'Circuits (desplegable segun el anterior)') }}
                    <select disabled id="f_circuit" name="f_circuit">
                        <option selected disabled value="-1" id="default_cir_option">Escoge una categoria primero</option>                        
                        @foreach ($data['cirs'] as $cir)
                            <option value="{{ $cir->cir_id }}">{{ $cir->cir_nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        {{ Form::close() }}
    </body>
</html>
