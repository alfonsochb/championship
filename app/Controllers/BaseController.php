<?php
namespace App\Controllers;


use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


/**
 * @package     Proyectos CodeIgniter
 * @category    Sistemas de recursos para usar en los proyectos.
 * @author      Alfonso Chavez Baquero
 * @copyright   2021-2023 Alfonso Chávez Baquero
 * @link        https://github.com/alfonsochb Visita mi página GitHub
 * @since       Version 1.0.0
 * @filesource  proyecto\app\Controllers\BaseController.php
 * @see         BaseController proporciona un lugar conveniente para cargar componentes y realizar funciones que son necesarias para todos sus controladores.
 *              Amplíe esta clase en cualquier controlador nuevo: la clase Home amplía BaseController
 *              Por seguridad, asegúrese de declarar cualquier método nuevo como protegido o privado.
 */
class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;


	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 * @var array
	 */
	protected $helpers = [];


	/**
	 * @method Constructor.
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->session = \Config\Services::session();
	}


    /**
     * @method Método para validar persona autenticada.
     * @return (void) - Devuelve continuación de procesos.
     */
    public function checkAuth()
    {
        $session = session();
        if ( $session->has('logged_in') and $session->has('user_email') ) {
            return true;
        }
        // Direccionarlo al login.
        //throw new \CodeIgniter\Router\Exceptions\RedirectException(site_url('login'), 301);

        // Direccionarlo a una pagina no encontrada.
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("El recurso no existe o es restingido.");
        exit(0);
    }
    

    /**
     * @method Método para guardar log cuando ocurren errores.
     * @param (string or array) $messages - Mensajes a ser guardados.
     * @return (void) - Devuelve continuación del proceso.
    */
    public function saveLogsApp( $messages=null )
    {
    	$moment = date( "Y-m-d H:i:s" );
        $path_logs = WRITEPATH."logs";
    	if ( !file_exists($path_logs) or !is_dir($path_logs) ) return;
        
        $file_name = $path_logs.DIRECTORY_SEPARATOR."applogs_".date("Ymd").".log";
        if ( $file_open=fopen( $file_name, 'a+') ){
            if ( (is_array($messages) or is_object($messages)) and !empty($messages) ) {
                $messages = @array_map('trim', $messages);
                foreach ($messages as $key => $message) {
                    $write = $moment." - $key: $message".PHP_EOL;
                    fwrite($file_open, $write);  
                }
            }else if( !is_array($messages) and !is_object($messages) and !empty($messages)   ){
                $message =@trim($messages);
                $write = "$moment - message: $message".PHP_EOL;
                fwrite($file_open, $write);
            }
            fwrite($file_open, PHP_EOL);
            fclose($file_open);
        }
        return;
    }


    /**
     * @method Método para guardar log cuando ocurren errores.
     * @param (string or array) $messages - Mensajes a ser guardados.
     * @return (void) - Devuelve continuación del proceso.
    */
    public function saveLogsJson( $messages=null )
    {
        $path_logs = WRITEPATH."logs";
        if ( file_exists($path_logs) and is_dir($path_logs) and '(null)'!==$messages ){
            $moment = date( "Y-m-d H:i:s" );
            $file_name = $path_logs.DIRECTORY_SEPARATOR."jsonlogs_".date("Ymd").".json";
            $database = [];
            if ( file_exists($file_name) and is_file($file_name) ) {
                $database = json_decode( file_get_contents( $file_name ), true );
            }

            if ( is_array($messages) ) {
                $messages = (object)$messages;
            }
            if ( is_object($messages) ) {
                 $aux = [
                    'code'      => (isset($messages->code) and is_numeric($messages->code)) ? $messages->code : 0,
                    'message'   => (isset($messages->message) and !empty($messages->message)) ? $messages->message : null,               
                    'file'      => (isset($messages->file) and !empty($messages->file)) ? $messages->file : null,
                    'line'      => (isset($messages->line) and is_numeric($messages->code)) ? $messages->line : 0,
                ];               
            }
            if ( !is_array($messages) and !is_object($messages) ) {
                 $aux = [
                    'code'      => 0,
                    'message'   => $messages,               
                    'file'      => null,
                    'line'      => 0,
                ];  
            }
            if ( $aux and !empty($aux) ) {
                $database[] = $aux;
                $write = fopen( $file_name, "w" );
                if ( flock( $write, LOCK_EX) ) { // adquirir un bloqueo exclusivo
                    ftruncate( $write, 0 );      // truncar el fichero
                    fwrite( $write, json_encode($database, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) );
                    fflush( $write );            // volcar la salida antes de liberar el bloqueo
                    flock( $write, LOCK_UN );    // liberar el bloqueo
                }
                fclose( $write );
            }
        }
        return;
    }


}