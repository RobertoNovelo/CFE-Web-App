<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report extends CFE_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function status()
	{
		$workerID	= $this->input->post('workerID');
        $reportID	= $this->input->post('reportID');
        $status		= $this->input->post('status');

        //Validate inputs used when session==1;
        if ($workerID && $reportID && $status)
        {
        	$this->load->model('set/set_report');
        	
        	$this->set_report->status($reportID, $status);
        	
        	$this->load->model('get/get_report');
            
            $publicComment = json_decode($this->get_report->publicComment_by_id($reportID),TRUE);
            
        	$this->load->model('get/get_worker');
        	
        	$date = new DateTime();
			$timestamp = $date->format('Y-m-d H:i:s');
			
			switch($status)
			{
				case 1:
					$estado = "Pendiente";
				break;
				case 2:
					$estado = "En revisión";
				break;
				case 3:
					$estado = "Resolviendo";
				break;
				default:
					$estado = "Cerrado";
				break;
			}
            
	        $publicComment[] = array
            (
            	'workerName'	=> $this->get_worker->name($workerID),
            	'comment'		=> "Se cambió el estado del reporte a $estado",
            	'date'			=> $timestamp
            );
            
            
            $this->load->model('set/set_worker');
            
            $this->set_worker->public_comment($reportID,json_encode($publicComment));
            
	        $response['requestStatus'] = 'OK';
        }
        else
        {
	        $response['requestStatus'] = 'NOK1';
        }
        
        echo json_encode($response);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */