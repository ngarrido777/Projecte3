<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar participant</title>
    <script>
        document.addEventListener('DOMContentLoaded', f_main);

        function f_main()
        {
            document.getElementById('id_esport').addEventListener('change', f_crida);
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

            fetch('/api/getCircuitsCursaCategoria' + id)
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
    </script>
</head>
<body>
    <h1>Assignació de participants</h1>
    {{ Form::open(['url' => 'asignarparticipant', 'method' => 'post']) }}
        @csrf
        <div>
            {{ Form::label('l_circuits', 'Circuits:') }}
            <div>
                <select id="id_esport" name="c_esport">
                    <option selected disabled value="-1">Tria l'esport</option>
                    @foreach ($esports as $esp)
                        @if($ultims_camps["l_esport"] == $esp->esp_id)
                            <option value="{{ $esp->esp_id  }}" selected>{{ $esp->esp_nom }}</option>
                        @else
                            <option value="{{ $esp->esp_id  }}">{{ $esp->esp_nom }}</option>
                        @endif
                    @endforeach
                </select>
                {{ Form::label(null, $errors['e_esport'], ['class' => 'error']) }}
            </div>
            {{ Form::label('l_categories', 'Categories:') }}
            <div>
                <select disabled name="id_categoria">
                    <option selected disabled value="-1" id="default_cir_option">Tria un esport primer</option>
                </select>
            </div>
        </div>
    {{ Form::close() }}
</body>
</html>