<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * @package 	Proyectos CodeIgniter
 * @category 	Sistemas de recursos para usar en los proyectos.
 * @author 		Alfonso Chavez Baquero
 * @copyright 	2021-2023 Alfonso Chávez Baquero
 * @link 		https://github.com/alfonsochb Visita mi página GitHub
 * @since 		Version 1.0.0
 */
class Auth extends BaseController
{


    /**
     * Método para mostrar formulario de login.
     * @return (view) - Devuelve vista del formulario.
     */
    public function login(){
    	$session = session();
    	if ( $session->has('logged_in') && $session->has('email') ) {
    		return redirect()->route('user');
    	}
    	return view('auth/login', [
    		'meta_tit' => 'Iniciar sesión',
    		'meta_des' => 'Acceso al sistema.',
    		'meta_key' => 'Iniciar sesión',
    	]);
    }


    /**
     * Método para iniciar una sesión.
     * @throws Exception por método de solicitud y por validación de datos.
     * @return (redirect) - Devuelve una redirección a perfil de persona autenticada.
     */
    public function authenticate(){
    	try {
    		$session = session();
    		if ( $this->request->getMethod(TRUE)!=='POST' or !$this->request->getPost('csrf_test_name') ) {
    			throw new \RuntimeException('Acción no permitida', 404);
    		}

    		if ( $session->has('logged_in') && $session->has('user_email') ) {
				return redirect()->route('user/profile'); // Perfil de usuario.
			}

			$rules = [
				'email' => "required|min_length[6]|valid_email",
				'password'  => 'required|min_length[8]'
			];
			if ( !$this->validate($rules) ){
				foreach ($this->validator->getErrors() as $key => $error) {
					throw new \RuntimeException(strip_tags($error), 404);
				}
			}

			$email = trim( $this->request->getVar('email', FILTER_SANITIZE_EMAIL) );
			$password = md5( trim( $this->request->getPost('password') ) );

			$model = new \App\Models\UserModel();
			$user = $model->select(['id', 'name', 'surname', 'role', 'avatar', 'email', 'status'])
				->where('email', $email)
				->where('password', $password)
				->where('status', 'A')
				->first();

			#echo "<pre>"; print_r($this->request->getVar()); print_r($user); die;

			if ( $user and is_array($user) and !empty($user) ) {
				$new_data = array_combine([
					'user_id', 
					'user_name', 
					'user_surname', 
					'user_role', 
					'user_avatar', 
					'user_email', 
					'user_status'
				], $user);
				$new_data['logged_in'] = true;				
				$session->set($new_data);
	        	return redirect()->route('user/profile'); // Perfil de usuario.
	        }else{
	        	throw new \RuntimeException('La combinación de correo y clave ingresada es incorrecta.', 404);
	        }
	    }catch (\Exception $e){
	    	$session->setFlashdata('errores', $e->getMessage());
	    	return redirect()->back()->withInput();
	    }
	    return redirect()->back();
	}


    /**
     * Método para mostrar terminar una sesión.
     * @return (redirect) - Devuelve redirección a p{agina principal sin usuario autenticado.
     */
    public function logout(){
    	$session = session();
    	if ( $this->request->getMethod(true)!=='POST' && $this->request->has('csrf_test_name') ) {
    		throw new \RuntimeException('Acción no permitida', 404);
    	}
    	if ( isset($_SESSION['logged_in']) && $this->request->getVar('logout')=='LOGOUT' ) {
    		unset(
    			$_SESSION['user_id'],
    			$_SESSION['user_name'],
    			$_SESSION['user_surname'],
    			$_SESSION['user_role'],
    			$_SESSION['user_avatar'],
    			$_SESSION['user_email'],
    			$_SESSION['user_status'],
    			$_SESSION['logged_in']
    		);
    	}
    	$session->destroy();
    	return redirect()->route('/');
    }


}


