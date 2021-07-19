<?php
namespace App\Controllers;

/**
 * @category    Controlador de la programacion.
 * @author      Alfonso Chavez Baquero
 * @copyright   2021-2023 Alfonso Chávez Baquero
 * @link        https://github.com/alfonsochb Visita mi página GitHub
 * @since       Version 1.0.0
 */
class Programming extends BaseController
{
	

	public function index()
	{
        $objChamps = new \App\Libraries\WorldChampionship;
        $programation = $objChamps->theWorldCup->allProgramming;
        $printer = [];
        foreach ($programation as $key => $value) {
            $printer[$value->phase][] = $value;
        }
        $titles = [
            'GRUPOS' => 'Fase de grupos',
            'OCTAVOS' => 'Fase octavos de final',
            'CUARTOS' => 'Fase de cuartos de final',
            'SEMIFINALES' => 'Semi finales',
            'TERCERP' => 'Disputa por el tercer puesto',
            'FINAL' => 'Gran final'
        ];
        //echo "<pre>"; print_r($printer); die;
		return view('programming/index', [
            'meta_tit' => "Programación deportiva",
            'meta_des'  => "Encuentros deportivos entre Clubes",
            'meta_key' => config('Achb')->appKeywords.", deportistas, estrellas, jugadores",
            'allConf' => $printer,
            'titles' => $titles
		]);
	}


    public function info()
    {
        $objChamps = new \App\Libraries\WorldChampionship;
        $all = $objChamps->theWorldCup;

        $printer = [];
        foreach ($all->allProgramming as $key => $value) {
            if ($value->status_play=='ON') {
                $printer[$value->phase][] = $value;
            }
        }

        $titles = [
            'GRUPOS' => 'Fase de grupos',
            'OCTAVOS' => 'Fase octavos de final',
            'CUARTOS' => 'Fase de cuartos de final',
            'SEMIFINALES' => 'Semi finales',
            'TERCERP' => 'Disputa por el tercer puesto',
            'FINAL' => 'Gran final'
        ];

        $parrafo ="Este es un informe de lo acontesido entorno a la programación del Mundial de futbol donde participan ".$all->countTeams;
        $parrafo.=" paises para jugar ".$all->countGames." partidos en busca de la copa del REY. En este Mudial de futbol participan los paises: ";
        foreach ($all->allTeams as $key => $info) {
            $parrafo.=$info->country_name.", ";
        }
        $parrafo = substr($parrafo, 0, -2).". ";
        $parrafo.="Hasta el momento se han jugado {$all->countGamesPlayed} partidos y se han mostrado {$all->countCardsY} tarjetas amarillas y {$all->countCardsR} tarjetas rojas.";

        return view('programming/info', [
            'meta_tit' => "Programación deportiva",
            'meta_des'  => "Encuentros deportivos entre Clubes",
            'meta_key' => config('Achb')->appKeywords.", deportistas, estrellas, jugadores",
            'allConf' => $printer,
            'titles' => $titles,
            'resumen' => $parrafo,
            'date_article' => $objChamps->getTextFromDate(date("Y-m-d"))
        ]);
    }

	
}
