<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CursesCircuitsCheckpointsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('curses')->insert([
            [
                'cur_id' => 1,
                'cur_nom' => 'Tour de Barcelona',
                'cur_data_inici' => '2021-03-10',
                'cur_data_fi' => '2021-03-14',
                'cur_lloc' => 'Barcelona',
                'cur_esp_id' => 1,
                'cur_est_id' => 2,
                'cur_desc' => 'Barcelona está lleno de maravillas, pero las conoces todas?? Vives cerca pero nunca has tenido timepo de echarle un ojo? Es hora de dejar de viajar lejos y conocer más sobre lo que tienes cerca, esta cursa pasa por las calles mas famosas de barcelona para ver sus espectaculares edificios y monumentos, pero no te pares a verlos, no querrás quedar en última posición! Tras la cursa se hará una macrobarabcoa en la Barceloneta, con cava para el ganador.',
                'cur_web' => 'www.bcnroutes.com',
                'cur_limit_inscr' => 120,
                'cur_foto' => base64_encode(file_get_contents(public_path('img/koala-head.jpg')))
            ],
            [
                'cur_id' => 2,
                'cur_nom' => 'carrera rural',
                'cur_data_inici' => '2023-06-30',
                'cur_data_fi' => '2023-07-02',
                'cur_lloc' => 'Piera',
                'cur_esp_id' => 2,
                'cur_est_id' => 2,
                'cur_desc' => 'La mejor carrera del año ha llegado! Con sus circuitos forestales destinados a ver pura naturaleza, te ayudarán a desconectar mientras mantienes tu cuerpo en forma. Todo entre bosques, rios y rieras, ademas en verano! Para que disfrutes de los bichos y la humedad.',
                'cur_web' => 'www.carrerarural.com',
                'cur_limit_inscr' => 120,
                'cur_foto' => base64_encode(file_get_contents(public_path('img/shrek.jpg')))
            ],
            [
                'cur_id' => 3,
                'cur_nom' => 'cursa de año nuevo',
                'cur_data_inici' => '2020-12-31',
                'cur_data_fi' => '2021-01-02',
                'cur_lloc' => 'igualada',
                'cur_esp_id' => 1,
                'cur_est_id' => 2,
                'cur_desc' => 'Cursa de fin de año! listo para correr comiendote las uvas? Cuantas mas uvas comas mas vas a correr, pero tampoco es necesario, no queremos que nadie se atragante! La diversión es lo principal así que el ganador se llevará un lote de uvas!',
                'cur_web' => 'www.cursaanual.com',
                'cur_limit_inscr' => 120,
                'cur_foto' => base64_encode(file_get_contents(public_path('img/Mychtar_Snowdog.jpg')))
            ],
            [
                'cur_id' => 4,
                'cur_nom' => 'cursa de la muerte',
                'cur_data_inici' => '2024-11-01',
                'cur_data_fi' => '2024-11-02',
                'cur_lloc' => 'Piera',
                'cur_esp_id' => 2,
                'cur_est_id' => 2,
                'cur_desc' => 'Bienvenido a la cursa de la muerte, aqui morireis *todos*. Con un circuito gigante tanto para juniors como para profesionales, todo listo para quitarte las ganas de volver a coger una bicicleta!! Estas seguro de que quieres participar? Te esperamos, aquí. El más rápido se levará un premio bien gordo, pero para ello debe terminar la cursa, podrás sorevivir??? Mucha suerte corredores!',
                'cur_web' => 'www.curseofdeath.com',
                'cur_limit_inscr' => 120,
                'cur_foto' => base64_encode(file_get_contents(public_path('img/flamingo.jfif')))
            ],
            [
                'cur_id' => 5,
                'cur_nom' => 'CUrsa de sant Valentí',
                'cur_data_inici' => '2024-02-15',
                'cur_data_fi' => '2024-02-14',
                'cur_lloc' => 'Torremolinos',
                'cur_esp_id' => 2,
                'cur_est_id' => 5,
                'cur_desc' => 'Este san valentin prepara tu rosa porque esta va a ser la cita más sudorosa de tu vida!! Tras correr 7km sin pausa se te van a quitar las ganas de irte a cenar con tu pareja, por eso, para las personas que vengan en pareja tienen cena gratiuita al terminar, un bocadillo de fuet con un zumo de piña. Si vienes solo te damos un vaso de agua. Como premio tenemos preparado un spa para dos personas.',
                'cur_web' => 'www.loverunning.com',
                'cur_limit_inscr' => 200,
                'cur_foto' => base64_encode(file_get_contents(public_path('img/WAffle.PNG')))
            ]
        ]);
        
        DB::table('circuits')->insert([
            [
                'cir_id' => 1,
                'cir_num' => 1,
                'cir_cur_id' => 1, 
                'cir_distancia' => 2000, 
                'cir_nom' => 'circuit 1 rut 1',
                'cir_preu' => 12,
                'cir_temps_estimat' => '70'
            ],
            [
                'cir_id' => 2,
                'cir_num' => 2,
                'cir_cur_id' => 1, 
                'cir_distancia' => 5000, 
                'cir_nom' => 'circuit 2 rut 1',
                'cir_preu' => 12,
                'cir_temps_estimat' => '40'
            ],
            [
                'cir_id' => 3,
                'cir_num' => 1,
                'cir_cur_id' => 2, 
                'cir_distancia' => 4400, 
                'cir_nom' => 'circuit 1 rut 2',
                'cir_preu' => 12,
                'cir_temps_estimat' => '30'
            ],
            [
                'cir_id' => 4,
                'cir_num' => 2,
                'cir_cur_id' => 2, 
                'cir_distancia' => 3500, 
                'cir_nom' => 'circuit 2 rut 2',
                'cir_preu' => 12,
                'cir_temps_estimat' => '120'
            ],
            [
                'cir_id' => 5,
                'cir_num' => 1,
                'cir_cur_id' => 3, 
                'cir_distancia' => 2700, 
                'cir_nom' => 'circuit 1 rut 3',
                'cir_preu' => 12,
                'cir_temps_estimat' => '60'
            ],
            [
                'cir_id' => 6,
                'cir_num' => 1,
                'cir_cur_id' => 4, 
                'cir_distancia' => 6000, 
                'cir_nom' => 'circuit 1 rut 4',
                'cir_preu' => 12,
                'cir_temps_estimat' => '60'
            ],
            [
                'cir_id' => 7,
                'cir_num' => 1,
                'cir_cur_id' => 5, 
                'cir_distancia' => 7000, 
                'cir_nom' => 'circuit 1 rut 5',
                'cir_preu' => 15,
                'cir_temps_estimat' => '60'
            ],
            [
                'cir_id' => 8,
                'cir_num' => 2,
                'cir_cur_id' => 5, 
                'cir_distancia' => 7000, 
                'cir_nom' => 'circuit 2 rut 5',
                'cir_preu' => 15,
                'cir_temps_estimat' => '60'
            ],
        ]);

        DB::table('checkpoints')->insert([
            [
                'chk_id' => 1,
                'chk_cir_id' => 7,
                'chk_pk' => 100
            ],
            [
                'chk_id' => 2,
                'chk_cir_id' => 7,
                'chk_pk' => 200
            ],
            [
                'chk_id' => 3,
                'chk_cir_id' => 7,
                'chk_pk' => 300
            ],
            [
                'chk_id' => 4,
                'chk_cir_id' => 7,
                'chk_pk' => 400
            ],
            [
                'chk_id' => 5,
                'chk_cir_id' => 8,
                'chk_pk' => 150
            ],
            [
                'chk_id' => 6,
                'chk_cir_id' => 8,
                'chk_pk' => 250
            ],
            [
                'chk_id' => 7,
                'chk_cir_id' => 8,
                'chk_pk' => 350
            ],
            [
                'chk_id' => 8,
                'chk_cir_id' => 8,
                'chk_pk' => 450
            ],
        ]);
    }
}
