<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resultats de {{ $data['cursa']->cur_nom }}</title>
        <link rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
        <script>
            // var x = setInterval(function() {
                const url = "http://localhost:8000/api/getResultats/" + {!! $data['cursa']->cur_id !!}
                let xhr = new XMLHttpRequest()
                xhr.open('GET', url, true)
                xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
                xhr.send();
                xhr.onload = function() {
                    let arr = JSON.parse(xhr.response);
                    console.log(arr);
                }
            // },10000);
        </script>
        <style>
            .msg_inf,
            .msg_adv,
            .msg_err {
                font-weight: bold;
            }

            .msg_inf {
                color: green;
            }

            .msg_adv {
                color: goldenrod;
            }

            .msg_err {
                color: darkred;
            }

            .hidden {
                display: none;
            }

            img {
                width: 500px;
                height: 500px;
            }

            .content {
                display: flex;
                justify-content: space-around;
            }

            .header {
                margin: 10px 10px 30px;
            }
        </style>
    </head>
    <body>
        
    </body>
</html>
