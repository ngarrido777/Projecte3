<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar participant a {{ $data['cursa']->cur_nom }}</title>
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
    <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                
                const ddl_cats = document.getElementById('f_categoria')
                let ddl_cirs = document.getElementById('f_circuit')
                ddl_cirs.addEventListener('change', (event) => {
                    document.getElementById('recep').disabled = false;
                });

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

            function retirar(e) {
                console.log(e.id);
                let id_input = document.getElementById(e.id).parentNode.childNodes[11];
                id_input.name = 'ins_id_selected';
                let button = document.getElementById(e.id).parentNode.childNodes[9];
                button.click();
            }

            function participar(e) {
                console.log(e.id);
                let id_input = document.getElementById(e.id).parentNode.childNodes[11];
                id_input.name = 'ins_id_selected';
                let button = document.getElementById(e.id).parentNode.childNodes[7];
                button.click();
            }
    </script>
    <style>
        .ins_row {
            width: 100%;
            background-color: #ddd;
            padding: 10px 40px;
            border-bottom: 1px solid black;
        }
        
        .ins_row:has(.retirat) {
            background-color: tomato;
        }
        
        .ins_row:has(.participa) {
            background-color: mediumseagreen;
        }

        .ins_row:last-child {
            border: none;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Assignació de participants</h1>
    {{ Form::open(['method' => 'post']) }}
        @csrf
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
        @if (isset($data['selected']['cat']) && $data['selected']['cir'])
            {{ Form::text('selected_cat', $data['selected']['cat']->cat_id, ['class' => 'hidden']) }}
            {{ Form::text('selected_cir', $data['selected']['cir']->cir_id, ['class' => 'hidden']) }}
        @endif
        {{ Form::submit('Recepcio!', ['name' => 'f_recep', 'id' => 'recep', 'disabled' => 'true', 'style' => 'margin-left: 15px;']) }}
        <br>
        <br>
        @php($i = 0)
        @foreach ($data['inscripcions'] as $ins)
            <div class="ins_row">
                @if (is_null($ins->ins_retirat))
                    <span>{{$ins->participant->par_nom}}</span>
                    <span id="p{{$i}}" class="btn btn-success" onclick="participar(this)">Participa</span>
                    <span id="r{{$i++}}" class="btn btn-danger" onclick="retirar(this)">Es retira</span>
                    {{ Form::submit('Paricipa', ['name' => 'f_recep_si', 'class' => 'btn btn-success hidden',]) }}
                    {{ Form::submit('Es retira', ['name' => 'f_recep_no', 'class' => 'btn btn-danger hidden',]) }}
                    {{ Form::text('ins_id', $ins->ins_id, ['class' => 'hidden']) }}
                @elseif ($ins->ins_retirat == '1')
                    <span class="retirat">{{$ins->participant->par_nom}}</span>
                    <span>Retirat</span>
                @else
                    <span class="participa">{{$ins->participant->par_nom}}</span>
                    <span>Participa</span>
                @endif
            </div>
        @endforeach
    {{ Form::close() }}
    <a href="/veurecursesadmin/{{$data['cursa']->cur_id}}" class="btn btn-secondary m-3 not-a">Tornar</a>
</body>
</html>