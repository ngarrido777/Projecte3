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

            div {
                margin-bottom: 30px;
            }

            .participante {
                display: flex;
            }

            .chk_complete {
                background-color: lime;
                padding: 10px;
                border-radius: 50px;
                margin: 0 10px;
            }

            .temps {
                font-size: 0.8em;
                margin-left: 6px;
            }

            .total {
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <h2> Resultats de: {{ $data['cursa']->cur_nom }} </h2>
        <p id="error"></p>
        <div id="res"></div>
    </body>
</html>

<script>
    function createDOM(div) {
        const url = "http://localhost:8000/api/getResultats/5"// + {!! $data['cursa']->cur_id !!}
        let xhr = new XMLHttpRequest()
        xhr.open('GET', url, true)
        xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
        xhr.send();
        xhr.onload = function() {
            div.innerHTML = "";
            let arr = JSON.parse(xhr.response);
            console.log(arr);
            let resultats = arr['resultats'];
            for (let cirs in resultats) {
                let cir = document.createElement("div");
                cir.innerHTML = "<h3> Circuit: " + resultats[cirs]['circuito']['cir_nom'] + "</h3>";

                let categorias = resultats[cirs]['categorias'];
                for (let cats in categorias) {
                    let cat = document.createElement("div");
                    cat.innerHTML = "<h5> --- Categoria: " + categorias[cats]['categoria']['cat_nom'] + "</h5>";

                    let participant = categorias[cats]['participantes'];
                    for (let pars in participant) {
                        let par = document.createElement("div");
                        par.innerHTML = "------ Corredor: " + participant[pars]['participante']['nom'] + " " + participant[pars]['participante']['cognoms'] + " (" + participant[pars]['participante']['dorsal'] + ")";
                        
                        let par_chks = document.createElement("div");
                        par_chks.classList.add("participante");

                        let checkpoint = participant[pars]['checkpoints']
                        let total = 0;
                        for (let chks in checkpoint) {
                            console.log("a");
                            let chk = document.createElement("div");
                            chk.classList.add("chk_complete");
                            temps = checkpoint[chks]['tiempo'];
                            total += temps;
                            if (total == 0) {
                                chk.innerHTML = "<b>Inici</b>";
                            } else {
                                let content = "<span class='total'>";
                                if (Math.trunc(total/60) != 0) {
                                    content +=  Math.trunc(total/60) + "m ";
                                }
                                content +=  Math.trunc(total%60) + "s</span><span class='temps'>(";
                                if (Math.trunc(temps/60) != 0) {
                                    content +=  Math.trunc(temps/60) + "m ";
                                }
                                content +=  Math.trunc(temps%60) + "s)</span>";
                                chk.innerHTML = content;
                            }

                            par_chks.appendChild(chk);
                        }
                        par.appendChild(par_chks);
                        cat.appendChild(par);
                    }
                    cir.appendChild(cat);
                }
                div.appendChild(cir);
            }
        }
    }

    window.onload = function() {
        if (/*{!! $data['cursa']->cur_est_id !!} != 5 && {!! $data['cursa']->cur_est_id !!} != 4*/ false) {
            let err_span = document.getElementById('error');
            err_span.classList.add('msg_err');
            err_span.innerText = "No hay resultados debido a que la ruta no está ni terminada ni en curso";
        } else {
            let div = document.getElementById('res');
            createDOM(div);
            var x = setInterval(function() {
                createDOM(div);
            },5000);
        }
    };
</script>