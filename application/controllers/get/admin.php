<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CFE_Controller {
	
	public function data()
	{
		$this->load->model('admin_data');
		
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		
		$response['data'] = $this->admin_data->get_failures();
		
		$response['data'] = array_merge(json_decode(json_encode($response['data']),TRUE), json_decode(json_encode($this->admin_data->get_issues()),TRUE));
		$response['data'] = array_merge(json_decode(json_encode($response['data']),TRUE), json_decode(json_encode($this->admin_data->get_workers()),TRUE));
/* 		array_merge($response['data'], $this->admin->get_workers()); */
		
		$response['data']["Todas las fallas"] = array
		(
			'category' => 'Reportes',
			'all' => TRUE,
			'dataType' => 1,
			'total' => $this->admin_data->get_total_failures()
		);
		
		$response['data']["Todas las quejas"] = array
		(
			'category' => 'Reportes',
			'all' => TRUE,
			'dataType' => 2,
			'total' => $this->admin_data->get_total_issues()
		);
		
		$response['data']["Todos los empleados"] = array
		(
			'category' => 'Empleados',
			'all' => TRUE,
			'dataType' => 3,
			'total' => $this->admin_data->get_total_workers()
		);
		
		echo json_encode($response);
		
	}
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */













