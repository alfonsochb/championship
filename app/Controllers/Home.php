<?php
namespace App\Controllers;

/**
 * @category    Controlador de las páginas publicas.
 * @author      Alfonso Chavez Baquero
 * @copyright   2021-2023 Alfonso Chávez Baquero
 * @link        https://github.com/alfonsochb Visita mi página GitHub
 * @since       Version 1.0.0
 */
class Home extends BaseController
{
	
    private $path_public;
    private $path_writable;

    public function __construct() 
    {
        $this->path_public = ROOTPATH.'public'.DIRECTORY_SEPARATOR;
        $this->path_writable = WRITEPATH.'uploads'.DIRECTORY_SEPARATOR;
    }


	public function welcome()
	{
        $objChamps = new \App\Libraries\WorldChampionship;
        $all = $objChamps->theWorldCup;
		return view('home/welcome', [
            'meta_tit'      => "Bienvenida - ".config('Achb')->appSiteName,
            'meta_des'      => config('Achb')->appDescription,
            'meta_key'      => config('Achb')->appKeywords.", deportistas, estrellas, jugadores",
            'teams'         => $all->allTeams,
            'countGroups'   => $all->countGroups
		]);
	}

	
}
