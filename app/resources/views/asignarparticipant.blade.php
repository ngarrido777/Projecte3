<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar participant a {{ $data['cursa']->cur_nom }}</title>
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
    </script>
    <style>
        .ins_row {
            width: 100%;
            background-color: #ddd;
            padding: 10px 40px;
            border-bottom: 1px solid #aaa;
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
        {{ Form::submit('Recepcio!', ['name' => 'f_recep', 'id' => 'recep', 'class' => 'btn btn-success', 'disabled' => 'true']) }}
        @foreach ($data['inscripcions'] as $ins)
            <div class="ins_row">
                <span>{{$ins->participant->par_nom}}</span>
                {{ Form::text('ins_id', $ins->ins_id, ['class' => 'hidden']) }}
            </div>
        @endforeach
    {{ Form::close() }}
</body>
</html>