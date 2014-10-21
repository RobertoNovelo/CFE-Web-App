<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class worker extends CFE_Controller {

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
		$workerID = $this->input->post('userID');
		
		if($workerID)
		{
			$this->load->model('get/get_worker');
                	
        	$userReports = $this->get_worker->reports($workerID);
        	
        	if($userReports)
        	{
            	$count = count($userReports);
        	
	        	for($i=0; $i<$count;$i++)
	        	{	
		        	$response['reports'][$i] = $userReports[$i];
		        	$response['reports'][$i]->publicComments = json_decode($userReports[$i]->publicComments);
		        	$response['reports'][$i]->privateComments = json_decode($userReports[$i]->privateComments);
	        	}

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













