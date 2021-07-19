<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * @category    Controlador de paises.
 * @author      Alfonso Chavez Baquero
 * @copyright   2021-2023 Alfonso Chávez Baquero
 * @link        https://github.com/alfonsochb Visita mi página GitHub
 * @since       Version 1.0.0
 */
class Groups extends BaseController
{

    public function index()
    {
        $obj = new \App\Libraries\WorldChampionship;
        $champs = $obj->theWorldCup;
        return view('groups/index', [
            'meta_tit'  => "Bienvenidos",
            'meta_des'  => "Página de bienvenida",
            'meta_key'  => "",
            'groups'    => $champs->allGroups
        ]);
    }
}
