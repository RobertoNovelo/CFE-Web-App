<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class private_comment extends CFE_Controller {

	/**
	 * Get Worker controller.
	 * 
	 * This controller will process queries demanding worker data.
	 *
	 * Maps to the following URL:
	 * 		/get/worker.php
	 *
	 */
	
	public function index()
	{
		$workerID	= $this->input->post('workerID');
        $reportID	= $this->input->post('reportID');
        $comment	= $this->input->post('comment');
        
        //Validate inputs used when session==1;
        if ($workerID && $reportID && $comment)
        {        
            $this->load->model('get/get_report');
            
            $publicComment = json_decode($this->get_report->privateComment_by_id($reportID),TRUE);
            
        	$this->load->model('get/get_worker');
        	
        	$date = new DateTime();
			$timestamp = $date->format('Y-m-d H:i:s');
	           
	        $publicComment[] = array
            (
            	'workerName'	=> $this->get_worker->name($workerID),
            	'comment'		=> $comment,
            	'date'			=> $timestamp
            );
            
            
            $this->load->model('set/set_worker');
            
            $this->set_worker->private_comment($reportID,json_encode($publicComment));
                           	
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













