<?php
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
    	$clase = 'error';
    }
    
    if( $session->has('info') ) {
    	$mensaje = $session->getFlashdata('info');
    	$clase = 'info';
    }

	if( isset($mensaje) && is_string($mensaje) && !empty($mensaje) ){
		echo '<script type="text/javascript">$(function(){swal({ icon:"'.$clase.'", title:"Mensaje!", text:"'.$mensaje.'", button:"OK", closeOnClickOutside:false }); });</script>';
	}