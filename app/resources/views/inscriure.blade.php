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
        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                const checkbox = document.getElementById('ckb_federat')
                let f_block = document.getElementById('num_federat_block')
                if (checkbox.checked) {
                    f_block.classList.remove('hidden');
                }

                checkbox.addEventListener('change', (event) => {
                    if (event.currentTarget.checked) {
                        f_block.classList.remove('hidden');
                    } else {
                        f_block.classList.add('hidden');
                    }
                });

                const ddl_cats = document.getElementById('f_categoria')
                let ddl_cirs = document.getElementById('f_circuit')
                ddl_cats.addEventListener('change', (event) => {
                    ddl_cirs.disabled = false;
                    ddl_cirs.options[0].text = "Escoje el circuito!";   

                    for (let i=ddl_cirs.children.length-1; i > 0 ; i--) {
                        ddl_cirs.removeChild(ddl_cirs.children[i])
                    }

                    let postObj = { 
                        cat: ddl_cats.options[ddl_cats.selectedIndex].value,
                        cur_id: {!! $data['cursa']->cur_id !!}
                    }
                    let post = JSON.stringify(postObj)
                    const url = "http://localhost:8000/api/getCircuitsCursaCategoria"
                    let xhr = new XMLHttpRequest()
                    xhr.open('POST', url, true)
                    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
                    xhr.send(post);
                    xhr.onload = function() {
                        let arr = JSON.parse(xhr.response);
                        arr.forEach(element => {
                            var option = document.createElement("option");
                            option.text = element['cir_nom'];
                            option.value = element['cir_id'];
                            ddl_cirs.appendChild(option);
                        });
                        ddl_cirs.value = -1;
                    }
                });
            });
        </script>
        <style>
            .hidden {
                display: none;
            }
            .content {
                display: flex;
                justify-content: space-around;
            }

            .header {
                margin: 10px 10px 30px;
            }

            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }
            h1.text-center {
                text-align: center;
                padding: 20px;
                color: black;
                margin: 0;
            }
            .caixa {
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: flex-start;
                margin: 20px;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            .caixa > div {
                flex: 1;
                margin: 10px;
            }
            div > div {
                margin-bottom: 15px;
            }
            label {
                font-weight: bold;
                display: block;
                margin-bottom: 5px;
            }
            p.salt, input.salt {
                margin: 0;
                padding: 5px;
                background-color: #e9ecef;
                border-radius: 5px;
                width: 80%;
            }
            a.btn {
                display: inline-block;
                padding: 10px 15px;
                margin: 5px 0;
                text-align: center;
                text-decoration: none;
                border-radius: 5px;
                color: white;
            }
            a.btn-success {
                background-color: #28a745;
            }
            a.btn-primary {
                background-color: #007bff;
            }
            .caixa img {
                max-width: 100%;
                border-radius: 10px;
            }

            .formulari{
                width: 50%;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <p class="h2">Inscripció a {{ $data['cursa']->cur_nom }}</p>
            <p> Inscrits: {{ $fields['inscrits'] }} / {{ $data['cursa']->cur_limit_inscr }} </p>
            @if (!is_null($message))
                <p class="{{ $message['type'] }}">{{ $message['text'] }}</p>
            @endif

        </div>
        <div class="caixa">
            {{ Form::open(['method' => 'post']) }}
                @csrf
                <div class="content">
                    <div class="formulari">
                        <div>
                            {{ Form::label('l_nom', 'Nom') }}
                            {{ Form::text('f_nom', $fields['nom'], array('class'=>'salt')) }}
                        </div>
                        <div>
                            {{ Form::label('l_cognoms', 'Cognoms') }}
                            {{ Form::text('f_cognoms', $fields['cognoms'], array('class'=>'salt')) }}
                        </div>
                        <div>
                            {{ Form::label('l_nif', 'DNI') }}
                            {{ Form::text('f_nif', $fields['nif'], array('class'=>'salt')) }}
                        </div>
                        <div>
                            {{ Form::label('l_telefon', 'Teléfon') }}
                            {{ Form::text('f_telefon', $fields['telefon'], array('class'=>'salt')) }}
                        </div>
                        <div>
                            {{ Form::label('l_email', 'Correu electrònic') }}
                            {{ Form::text('f_email', $fields['email'], array('class'=>'salt')) }}
                        </div>
                        <div>
                            {{ Form::label('l_naix', 'Data de naixement') }}
                            {{ Form::date('f_naix', $fields['naix'], array('class'=>'salt')) }}
                        </div>
                        <div>
                            {{ Form::label('l_federat', 'Ets federat?') }}
                            {{ Form::checkbox('f_federat', null, $fields['federat'], array('id'=>'ckb_federat')) }}
                            <span id="num_federat_block" class="hidden">
                                {{ Form::label('l_num_federat', 'Num federat') }}
                                {{ Form::text('f_num_federat', $fields['codiFederat'], array('class'=>'salt')) }}
                            </span>
                        </div>
                        <div>
                            {{ Form::label('l_categoria', 'Categorias') }}
                            <select id="f_categoria" name="f_categoria">
                                <option selected disabled value="-1">Escoge tu categoría</option>
                                @foreach ($data['cats'] as $cat)
                                    <option value="{{ $cat->cat_id }}">{{ $cat->cat_nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            {{ Form::label('l_circuit', 'Circuits') }}
                            <select disabled id="f_circuit" name="f_circuit">
                                <option selected disabled value="-1" id="default_cir_option">Escoge una categoria primero</option>
                            </select>
                        </div>
                        <div>
                            @if ($fields['inscrits'] >= $data['cursa']->cur_limit_inscr)
                                {{ Form::submit('Inscribirm!', ['name' => 'f_ins','disabled' => 'true', 'class' => 'btn btn-danger']) }}
                            @else
                                {{ Form::submit('Inscribirm!', ['name' => 'f_ins', 'class' => 'btn btn-success']) }}
                            @endif

                            @if ($usu == null || !$usu->usr_admin)
                                <a href="/veurecursesadmin/{{$data['cursa']->cur_id}}" class="btn btn-primary mx-3">Torna</a>
                            @else
                                    <a href="/veurecurses/{{$data['cursa']->cur_id}}" class="btn btn-info mx-3">Torna</a>
                            @endif
                        </div>
                    </div>
                    <div>
                        <img src="data:image/jpeg;charset=utf-8;base64, {{ $data['cursa']->cur_foto }}" />
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </body>
</html>
