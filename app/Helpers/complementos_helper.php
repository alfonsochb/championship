<?php
if (! function_exists('fechaTexto')){
	/**
	 * Word Limiter
	 *
	 * Limits a string to X number of words.
	 *
	 * @param string  $str
	 * @param integer $limit
	 * @param string  $end_char the end character. Usually an ellipsis
	 *
	 * @return string
	 */
	function fechaTexto( $fecha='' ): string{
		
		$fecha = date_format(date_create($fecha), "Y-m-d");
		$p = explode("-", $fecha);
        $meses = [
        	'01' => 'Enero', 
        	'02' => 'Febrero', 
        	'03' => 'Marzo', 
        	'04' => 'Abril', 
        	'05' => 'Mayo', 
        	'06' => 'Junio', 
        	'07' => 'Julio', 
        	'08' => 'Agosto', 
        	'09' => 'Septiembre', 
        	'10' => 'Octubre', 
        	'11' => 'Noviembre', 
        	'12' => 'Diciembre'
        ];
        return $meses[$p[1]].' '.$p[2].' de '.$p[0];
	}
}

