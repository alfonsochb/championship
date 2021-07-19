<?php
namespace Config;


// Create a new instance of our RouteCollection class.
$routes = Services::routes();


// Load the system's routing file first, so that the app and ENVIRONMENT can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')){
	require SYSTEMPATH . 'Config/Routes.php';
}


// Router Setup
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function( $message=null ){
	$obj = new \App\Controllers\BaseController;
	$obj->saveLogsJson("404 Page Not Found - ".$message);
    return view('errors/html/error_404', [
    	"message" => "Esta página no está disponible en este momento",
    	"other" => "Es posible que el enlace esté roto o que se haya eliminado la página. Verifica que el enlace que quieres abrir es correcto."
    ]);
});
$routes->setAutoRoute(true);


/** --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
$routes->get('/', 'Home::welcome');


$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::authenticate');
$routes->post('logout', 'Auth::logout');
$routes->get('user/profile', 'Users::profile');


$routes->get('teams/download', 'Teams::download');
$routes->get('teams/photo/(:any)/(:any)', 'Teams::photo/$1/$2');
$routes->post('teams/cropper', 'Teams::cropper');
$routes->post('teams/create-csv', 'Teams::createMultiple');
$routes->resource('teams', ['only' => ['index', 'show', 'new', 'create', 'update', 'delete']]);


$routes->get('groups', 'Groups::index');
$routes->get('programming', 'Programming::index');
$routes->get('programming/info', 'Programming::info');

$routes->get('config', 'Config::config');
$routes->get('config/lottery', 'Config::lottery');
$routes->get('config/dates', 'Config::dates');
$routes->get('config/play', 'Config::play');
$routes->post('config/play-add', 'Config::playAdd');

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')){
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}