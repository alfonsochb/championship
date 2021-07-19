<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel; 


/**
 * @category    Controlador de usuarios del sistema.
 * @author      Alfonso Chavez Baquero
 * @copyright   2021-2023 Alfonso Chávez Baquero
 * @link        https://github.com/alfonsochb Visita mi página GitHub
 * @since       Version 1.0.0
 */
class Users extends BaseController
{


    /**
     * Constructor de la clase.
     * @see Verifica que el usuario este autenticado.
     */
    public function __construct() {
        $this->checkAuth();
    }


    /**
     * Método para mostrar datos de usuario.
     * @return (view) - Devuelve vista del usuario.
     */
    public function profile(){
        helper(['complementos', 'text']);
        try {
            $session = session();
            if ( !$session->has('logged_in') or !$session->has('user_id') ) {
                throw new \RuntimeException('No es posible ingresar, esta zona es restringida.', 001);
            }

            $user_model = new UserModel();
            $data = $user_model->select(['id', 'name', 'surname', 'avatar', 'email', 'status', 'created_at'])
                ->where('id', $session->get('user_id'))
                ->first();

            $data['date'] = fechaTexto($data['created_at']);// helper:complementos
            $data['foto'] = base_url('public/avatars/img/aavatar_none.jpg');
            if ( file_exists('./public/img/avatars/'.$data['avatar']) ) {
                $data['foto'] = base_url('public/img/avatars/'.$data['avatar']);
            }
            $user = (object)$data;
            return view('users/profile', [
                'meta_tit'  => $user->name.' '.$user->surname,
                'meta_des'  => 'Perfil de usuario.',
                'meta_key'  => $user->name.', '.$user->surname,
                'user'      => $user
            ]);
        } catch (\Exception $e){
            $this->saveLogsApp([
                "code"      => $e->getCode(),
                "message"   => $e->getMessage(),               
                "file"      => $e->getFile(),
                "line"      => $e->getLine()
            ], true);
            return view('errors/html/fallos', [ 
                'message' => $e->getMessage() 
            ]);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        exit(0);
    }

}
