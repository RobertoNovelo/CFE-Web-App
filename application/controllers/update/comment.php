<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class comment extends CFE_Controller {

	/**
	 * Get Worker controller.
	 * 
	 * This controller will process queries demanding worker data.
	 *
	 * Maps to the following URL:
	 * 		/get/worker.php
	 *
	 */
	
	public function reports()
	{
		$userID = $this->input->post('userID');
		
		if($userID)
		{
			$this->load->model('get/get_user');
                	
        	$userReports = $this->get_worker->reports($userID);
        	
        	if($userReports)
        	{
            	$response['reports'] = $userReports;
        	}
        	else
        	{
            	//No assigned reports
        	}
        	
        	$response['requestStatus'] = 'OK';	
		}
		else
		{
			$response['requestStatus'] = 'NOK1';
		}
		
		echo json_encode($response);
	}
	
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */













