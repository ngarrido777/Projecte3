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
            let change = document.getElementsByClassName('open');
            change[0].addEventListener('click', f_close);
            change[0].parentNode.parentNode.nextElementSibling.style.display = 'none';

            let n_ckp = document.getElementsByClassName('n_ckp');
            n_ckp[0].addEventListener('click', f_nckp);

            let sub_e = document.getElementsByClassName('el');
            sub_e[0].addEventListener('click', f_eliminar_ck);

            let l_eliminar = document.getElementsByClassName('Elimina');
            l_eliminar[0].addEventListener('click', f_eliminar);
            document.getElementById('afegirfila').addEventListener('click', f_crida);
            document.getElementById('id_esport').addEventListener('change', f_crida);

            document.getElementById('afegirfila').addEventListener('click', function(event) {
                event.preventDefault();
                let table = document.getElementById('t_circuits').getElementsByTagName('tbody')[0];
                let newRow = table.insertRow();
                let noms = ['Elimina','cc_dist[]','cc_nom','cc_preu','cc_temps','f_categoria','n_ckp'];

                for (let i = 0; i < 8; i++) {
                    let newCell = newRow.insertCell(i);
                    newCell.classList.add('editable');
                    let input = document.createElement('input');
                    let a = document.createElement('a');
                    let select = document.createElement('select');
                    let option = document.createElement('option');
                    let div = document.createElement('div');
                    switch(i){
                        case 0:
                            a.text = noms[i];
                            a.classList.add(noms[i]);
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
                            select.name = "id_categoria[]";
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
                            input.addEventListener('click', f_nckp);
                            newCell.appendChild(input);
                            break;
                        case 7:
                            div.classList.add("open");
                            div.addEventListener('click', f_close);
                            newCell.appendChild(div);
                            break;
                    }
                }
                let rowsubtable = table.insertRow();
                let td_pare = document.createElement('td');
                let subtable = document.createElement('table');
                let thead = document.createElement('thead');
                let tr_h = document.createElement('tr');
                let th_h = document.createElement('th');
                let th_h_2 = document.createElement('th');
                let tbody = document.createElement('tbody');
                let tr_h_2 = document.createElement('tr');
                let td = document.createElement('td');
                let td_2 = document.createElement('td');
                let input = document.createElement('input');
                let a = document.createElement('a');

                a.class = 'el';
                a.innerText = 'Elimina';
                a.addEventListener('click', f_eliminar_ck);

                input.type = 'text';
                input.name = 'cc_punt_k[]';
                input.step = "0.01";
                
                th_h.innerText = "Punt kilométric";
                th_h_2.innerText = "Eliminar";
                tr_h.appendChild(th_h_2);
                tr_h.appendChild(th_h);
                thead.appendChild(tr_h);
                subtable.appendChild(thead);
                
                td_2.appendChild(a);
                td.appendChild(input);
                tr_h_2.appendChild(td_2);
                tr_h_2.appendChild(td);
                tbody.appendChild(tr_h_2);
                subtable.appendChild(tbody);

                td_pare.appendChild(subtable);
                rowsubtable.appendChild(td_pare);
                rowsubtable.style.display = 'none';
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
            let select = document.getElementsByName('id_categoria[]');

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
            this.parentNode.parentNode.nextElementSibling.remove();
            this.parentNode.parentNode.remove();
        }

        function f_eliminar_ck()
        {
            this.parentNode.parentNode.remove();
        }

        function f_close()
        {
            this.classList.add("close");
            this.classList.remove("open");
            this.removeEventListener('click', f_close);
            this.addEventListener('click', f_open);

            this.parentNode.parentNode.nextElementSibling.style.display = 'block';
        }

        function f_nckp(e)
        {
            e.preventDefault();
            let tr = this.parentNode.parentNode.nextElementSibling;
            let td = tr.children;
            let table = td[0].children;
            let tbody = table[0].children;
            let sub_tr = tbody[1].children;
            
            let tr_add = document.createElement('tr');
            let td_add = document.createElement('td');
            let td_add_2 = document.createElement('td');
            let a = document.createElement('a');
            a.class = 'el';
            a.innerText = 'Elimina';
            a.addEventListener('click', f_eliminar_ck);
            let input_add = document.createElement('input');
            input_add.type = 'text';
            input_add.name = 'cc_punt_k[]';
            input_add.step = "0.01";
            td_add_2.appendChild(a);
            td_add.appendChild(input_add);
            tr_add.appendChild(td_add_2);
            tr_add.appendChild(td_add);
            tbody[1].appendChild(tr_add);
        }

        function f_open()
        {
            this.classList.add("open");
            this.classList.remove("close");
            this.removeEventListener('click', f_open);
            this.addEventListener('click', f_close);
            
            this.parentNode.parentNode.nextElementSibling.style.display = 'none';
        }
    </script>
    <style>
        a {
            cursor: pointer;
            color: #007bff !important;
        }
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
        .hidden{
            visibility: hidden;
        }
        .show{
            visibility: visible;
        }
        .error {
            display: block;
            margin-bottom: 20px;

            color: red;
        }

        .not-a {
            color: white !important;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="ml-3">
        <h1 class="p-3 mt-4">Creació de les Curses</h1>
        {{ Form::open(['url' => 'creaciocurses', 'method' => 'post', 'files' => true]) }}
            @csrf
            <div>
                <div>
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
                <h2 class="p-3 mt-4">Circuits</h2>
                <div class="col-12">
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
                                    <a class="Elimina">Elimina</a>
                                </td>
                                <td class="editable">
                                    <input type="number" name="cc_dist[]">
                                </td>
                                <td class="editable">
                                    <input type="text" name="cc_nom[]">
                                </td>
                                <td class="editable">
                                    <input type="number" name="cc_preu[]">
                                </td>
                                <td class="editable">
                                    <input type="text" name="cc_temps[]">
                                </td>
                                <td class="editable">
                                    <select disabled name="id_categoria[]">
                                        <option selected disabled value="-1" id="default_cir_option">Tria un esport primer</option>
                                    </select>
                                </td>
                                <td class="editable">
                                    <input type="submit" value="Checkpoint" class="n_ckp">
                                </td>
                                <td>
                                    <div class="open"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Eliminar</th>
                                                <th>Punt kilométric</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a class="el">Elimina</a>
                                                </td>
                                                <td>
                                                    <input type="text" step="0.01" name="cc_punt_k[]">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a class="mt-3" id="afegirfila">Afegir Circuit</a>
                </div>
            </div>
            <div>
                <div>
                    {{ Form::submit('Crear', ['name' => 'c_crear', 'class' => 'btn btn-primary m-3']) }}
                </div>
                <div>
                    @if($ok)
                        {{ Form::label('l_creada', 'Cursa creada correctament !') }}
                    @endif
                </div>
            </div>
        {{ Form::close() }}
        <a href="/filtrecurses" class="btn btn-secondary m-3 not-a">Tornar</a>
    </div>
</body>
</html>