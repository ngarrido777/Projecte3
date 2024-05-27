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
            let l_eliminar = document.getElementsByClassName('Elimina');
            l_eliminar[0].addEventListener('click', f_eliminar);
            document.getElementById('afegirfila').addEventListener('click', f_crida);
            document.getElementById('id_esport').addEventListener('change', f_crida);

            document.getElementById('afegirfila').addEventListener('click', function(event) {
                event.preventDefault();
                let table = document.getElementById('t_circuits').getElementsByTagName('tbody')[0];
                let newRow = table.insertRow();
                let noms = ['Elimina','cc_dist[]','cc_nom','cc_preu','cc_temps','f_categoria','n_ckp'];

                for (let i = 0; i < 7; i++) {
                    let newCell = newRow.insertCell(i);
                    newCell.classList.add('editable');
                    let input = document.createElement('input');
                    let a = document.createElement('a');
                    let select = document.createElement('select');
                    let option = document.createElement('option');
                    switch(i){
                        case 0:
                            a.href = "#";
                            a.text = noms[i];
                            a.class = noms[i];
                            a.addEventListener('click', f_eliminar);
                            newCell.appendChild(a);
                            break;
                        case 1:
                        case 3:
                            input.type = 'number';
                            input.name = noms[i];
                            newCell.appendChild(input);
                            break;
                        case 2:
                        case 4:
                            input.type = 'text';
                            input.name = noms[i];
                            newCell.appendChild(input);
                            break;
                        case 5:
                            select.disabled = true;
                            select.name = "id_categoria";
                            option.value = '-1';
                            option.textContent = 'Tria un esport primer';
                            option.disabled = true;
                            option.selected = true;
                            select.appendChild(option);
                            newCell.appendChild(select);
                            break;
                        case 6:
                            input.type = 'submit';
                            input.value = 'Checkpoint'
                            input.name = noms[i];
                            newCell.appendChild(input);
                            break;
                    }
                }
            });

            document.getElementById('t_circuits').addEventListener('click', function(event) {
                if (event.target.tagName === 'TD' && event.target.classList.contains('editable')) {
                    let input = event.target.querySelector('input');
                    input.focus();
                }
            });
        }

        function f_crida()
        {
            esport = document.getElementById('id_esport');
            if(esport.value == -1)
            {
                return;
            }

            let id = document.getElementById('id_esport').value;
            let select = document.getElementsByName('id_categoria');

            fetch('/api/getesportcategories/' + id)
                .then(response => response.json())
                .then(data => {
                    for(i=0;i<select.length;i++)
                    {
                        select[i].innerHTML = '';
                        let defaultOption = document.createElement('option');
                        defaultOption.value = '-1';
                        defaultOption.textContent = 'Tria una categoria';
                        defaultOption.disabled = true;
                        defaultOption.selected = true;
                        select[i].appendChild(defaultOption);
                        data.forEach(function(item) {
                            let option = document.createElement('option');
                            option.value = item.cat_esp_id;
                            option.textContent = item.cat_nom;
                            select[i].appendChild(option);
                        });
                        select[i].disabled = false;
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function f_eliminar()
        {
            
            this.parentNode.parentNode.remove();
        }
    </script>
    <style>
        .open {
            width: 16px;
            height: 16px;
            background-image: url("/img/add.png");
        }
        .close {
            width: 16px;
            height: 16px;
            background-image: url("/img/minus.png");
        }
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="ml-3">
        <h1 class="p-3 mt-4">Creació de les Curses</h1>
        {{ Form::open(['url' => 'creaciocurses', 'method' => 'post', 'files' => true]) }}
            @csrf
            <div class="row mt-5">
                <div class="col-md-3">
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
                        {{ Form::label('l_descripccio', '*Descripccio:') }}
                        {{ Form::text('c_descripccio', $ultims_camps['l_descripccio']) }}
                        {{ Form::label(null, $errors['e_descripcio'], ['class' => 'error']) }}
                    </div>
                    <div>
                        {{ Form::label('l_limit', 'Limit:') }}
                        {{ Form::number('c_limit', $ultims_camps['l_limit']) }}
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
                <div class="col-md-9">
                    <table class="table table-responsive" id="t_circuits">
                        <thead>
                            <tr>
                                <th>Eliminar</th>
                                <th>Distància</th>
                                <th>Nom</th>
                                <th>Preu</th>
                                <th>*Temps</th>
                                <th>Categories</th>
                                <th>Checkpoints</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <a href="#" class="Elimina">Elimina</a>
                                </td>
                                <td class="editable">
                                    <input type="number" name="cc_dist[]">
                                </td>
                                <td class="editable">
                                    <input type="text" name="cc_nom">
                                </td>
                                <td class="editable">
                                    <input type="number" name="cc_preu">
                                </td>
                                <td class="editable">
                                    <input type="text" name="cc_temps">
                                </td>
                                <td class="editable">
                                    <select disabled name="id_categoria">
                                        <option selected disabled value="-1" id="default_cir_option">Tria un esport primer</option>
                                    </select>
                                </td>
                                <td class="editable">
                                    <input type="submit" value="Checkpoint" name="n_ckp">
                                </td>
                                <td>
                                    <div class="close"></div>
                                </td>
                            </tr>
                            <tr class="subtaula">
                                <td>
                                    <table colspan="8">
                                        <thead>
                                            <tr>
                                                <th>Punt kilometric</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>a</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
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
                    @if($ok)
                        {{ Form::label('l_creada', 'Cursa creada correctament !') }}
                    @endif
                </div>
            </div>
        {{ Form::close() }}
        <div>
            {{ Form::open( ['url' => 'filtrecurses/','method' => 'post']) }}
                @csrf
                {{ Form::submit('Tornar', ['name' => 'c_tornar', 'class' => 'btn btn-secondary']) }}
            {{ Form::close() }}
        </div>
    </div>
</body>
</html>