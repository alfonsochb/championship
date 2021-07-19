<?php
	# SE MUESTRA CUANDO LOS MENSAJES SON EN ARRAY.
    $session = session();

    if( $session->has('success') ) {
    	$mensaje = $session->getFlashdata('success');
    	$clase = 'success';
    }

    if( $session->has('warning') ) {
    	$mensaje = $session->getFlashdata('warning');
    	$clase = 'warning';
    }

    if( $session->has('error') ) {
    	$mensaje = $session->getFlashdata('error');
    	$clase = 'danger';
    }

    if( $session->has('danger') ) {
    	$mensaje = $session->getFlashdata('danger');
    	$clase = 'danger';
    }
    
    if( $session->has('info') ) {
    	$mensaje = $session->getFlashdata('info');
    	$clase = 'info';
    }

    //echo "<pre>"; print_r($mensaje); die;
	if( isset($mensaje) && is_array($mensaje) && !empty($mensaje) ){
		$innerHtml ='<div class="alert alert-'.$clase.' alert-dismissible fade show shadow mb-3" role="alert">';
		$innerHtml.='
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
		if (count($mensaje)>1) {
			$innerHtml.='<strong>Mensajes!</strong>';
			$innerHtml.='<ul class="list-group list-group-flush">';
			foreach ($mensaje as $key => $value) {
				$innerHtml.='<li class="list-group-item bg-transparent">'.$value.'</li>';				
			}
			$innerHtml.='</ul>';
		}else{
			$innerHtml.='<strong>Mensaje!</strong>';
			foreach ($mensaje as $key => $value) {
				$innerHtml.='<p>'.$value.'</p>';
			}
		}	
		$innerHtml.='</div>';
		echo $innerHtml;
	}
?>

