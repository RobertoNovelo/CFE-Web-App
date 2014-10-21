<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class all extends CFE_Controller {

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
		$city = $this->input->post('city');
		
		if($city)
		{
			$this->load->model('get/get_report');
			
			$response['reports'] = array();
			
			$reports = $this->get_report->all_by_city($city);
			
			if($reports)
        	{
            	$count = count($reports);
        	
	        	for($i=0; $i<$count;$i++)
	        	{	
		        	$response['reports'][$i] = $reports[$i];
		        	$response['reports'][$i]->publicComments = json_decode($reports[$i]->publicComments);
		        	$response['reports'][$i]->privateComments = json_decode($reports[$i]->privateComments);
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













