<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CFE_Controller {

	/**
	 * Get Worker controller.
	 * 
	 * This controller will process queries demanding worker data.
	 *
	 * Maps to the following URL:
	 * 		/get/worker.php
	 *
	 */
	
	public function report()
	{
		$userID		= $this->input->post('userID');
		$lat		= $this->input->post('lat');
		$lng		= $this->input->post('lng');
		$type		= $this->input->post('type');
		$subType	= $this->input->post('subType');
		$desc		= $this->input->post('desc');
		$city		= $this->input->post('city');
		
		
		if($userID && $lat && $lng && $type && $subType && $desc && $city)
		{
			$this->load->model('set/set_user');
            
            $date = new DateTime();
			$timestamp = $date->format('Y-m-d H:i:s');
            
            $newReport = array
            (
            	'userID'			=> $userID,
            	'lat'				=> $lat,
            	'lng'				=> $lng,
            	'type'				=> $type,
            	'subType'			=> $subType,
            	'desc'				=> $desc,
            	'city'				=> $city,
            	'creationDate'		=> $timestamp,
            	'lastUpdate'		=> $timestamp,
            	'publicComments' 	=> json_encode(array()),
            	'privateComments'	=> json_encode(array())	
            );    	
            
            $this->set_user->report($newReport);
           
            $this->load->model('get/get_user');
                	
        	$userReports = $this->get_user->reports($userID);
        	
        	if($userReports)
        	{
            	$count = count($userReports);
        	
	        	for($i=0; $i<$count;$i++)
	        	{	
		        	$response['reports'][$i] = $userReports[$i];
		        	$response['reports'][$i]->publicComments = json_decode($userReports[$i]->publicComments);
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













