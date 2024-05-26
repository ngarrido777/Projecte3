<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creacio Curses</title>
    <script>
        document.addEventListener('DOMContentLoaded', f_main);

        function f_main()
        {
            document.getElementById('id_esport').addEventListener('change', function() {
                let id = document.getElementById('id_esport').value;
                let select = document.getElementById('id_categoria');

                fetch('/api/getesportcategories/' + id)
                    .then(response => response.json())
                    .then(data => {
                        select.innerHTML = '';
                        let defaultOption = document.createElement('option');
                        defaultOption.value = '-1';
                        defaultOption.textContent = 'Tria una categoria';
                        defaultOption.disabled = true;
                        defaultOption.selected = true;
                        select.appendChild(defaultOption);
                        data.forEach(function(item) {
                            let option = document.createElement('option');
                            option.value = item.cat_esp_id;
                            option.textContent = item.cat_nom;
                            select.appendChild(option);
                        });
                        select.disabled = false;
                    })
                    .catch(error => console.error('Error:', error));
            });
        }
    </script>
    <style>
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="p-3 mt-4">Creació de les Curses</h1>
        {{ Form::open(['url' => 'creaciocurses', 'method' => 'post', 'files' => true]) }}
            @csrf
            <div class="row mt-5">
                <div class="col-md-6">
                    <div>
                        {{ Form::label('l_nom', 'Nom:') }}
                        {{ Form::text('c_nom', $ultims_camps['l_nom']) }}
                        {{ Form::label(null, $errors['e_nom'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_data_inici', 'Data Inici:') }}
                        {{ Form::date('c_data_inici', $ultims_camps['l_data_inici']) }}
                        {{ Form::label(null, $errors['e_data_inici'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_data_fi', 'Data Fi:') }}
                        {{ Form::date('c_data_fi', $ultims_camps['l_data_fi']) }}
                        {{ Form::label(null, $errors['e_data_fi'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_lloc', 'Lloc:') }}
                        {{ Form::text('c_lloc', $ultims_camps['l_lloc']) }}
                        {{ Form::label(null, $errors['e_lloc'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_esport', 'Esport:') }}
                        <select id="id_esport" name="c_esport">
                            <option selected disabled value="-1">Tria l'esport</option>
                            @foreach ($esports as $esp)
                            <option value="{{ $esp->esp_id  }}">{{ $esp->esp_nom }}</option>
                            @endforeach
                        </select>
                        {{ Form::label(null, $errors['e_esport'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_categoria', 'Categoria:') }}
                        <select disabled id="id_categoria" name="f_categoria">
                            <option selected disabled value="-1" id="default_cir_option">Tria un esport primer</option>
                        </select>
                        {{ Form::label(null, $errors['e_esport'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_descripccio', '*Descripccio:') }}
                        {{ Form::text('c_descripccio', $ultims_camps['l_descripccio']) }}
                        {{ Form::label(null, $errors['e_descripcio'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_limit', 'Limit:') }}
                        {{ Form::text('c_limit', $ultims_camps['l_limit']) }}
                        {{ Form::label(null, $errors['e_limit'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_foto', 'Foto:') }}
                        {{ Form::file('c_foto', ['accept' => '.png , .jpg']) }}
                        {{ Form::label(null, $errors['e_foto'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_web', '*Web:') }}
                        {{ Form::text('c_web', $ultims_camps['l_web']) }}
                        {{ Form::label(null, $errors['e_web'], ['class' => 'error']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table" id="t_circuits">
                        <thead>
                            <tr>
                                <th>Distància</th>
                                <th>Nom</th>
                                <th>Preu</th>
                                <th>*Temps</th>
                                <th>Categories</th>
                                <th>Checkpoints</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                    <a href="#" class="mt-3" id="afegirfila">Afegir Circuit</a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    {{ Form::submit('Crear', ['name' => 'c_crear', 'class' => 'btn btn-primary']) }}
                </div>
                <div>
                    
                </div>
                <div>
                    @if($ok)
                        {{ Form::label('l_creada', 'Cursa creada correctament !') }}
                    @endif
                </div>
            </div>
        {{ Form::close() }}
    </div>
</body>
</html>