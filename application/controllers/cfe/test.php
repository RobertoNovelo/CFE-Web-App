<?php
class test extends CFE_Controller {

	public function obtener_estados()
	{
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		
		echo $this->CFE_ObtenerEstados();
	}
	
}