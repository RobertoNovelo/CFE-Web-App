<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class auth extends CFE_Controller {

	/**
	 * Worker Login controller.
	 * 
	 * This controller will process queries with auth requirements.
	 *
	 * Maps to the following URL:
	 * 		/worker/auth.php
	 *
	 */
	 
	public function login()
	{
        $pushToken	= $this->input->post('pushToken');
        $lat		= $this->input->post('lat');
        $lng		= $this->input->post('lng');
        
        //Validate inputs used when session==1;
        if ($pushToken && $lat && $lng)
        {
            $this->load->model('user/user_auth_model');
            $userID = $this->user_auth_model->find_user_by_push_token($pushToken);

            if($userID)
            {         	
                $this->load->library('session');
                
            	$sessionID = uniqid();
            
            	$sessionData = array
				(
					'userID'	=> $userID,
					'sessID'	=> $sessionID,
					'loggedIn'	=> true
				);
				
				$this->session->set_userdata($sessionData);
				
				$this->user_auth_model->set_new_sess_id($userID,$sessionID);
				
            	$this->load->model('get/get_user');
            	
            	$this->load->model('set/set_user');
            	
				$this->set_user->lat_lng($userID, $lat, $lng);
				
            	$response['userID'] = $userID;
            	
            	$response['reports'] = array();
            	
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
            	
            	$sessionID = uniqid();
            	
            	$newUser = array
				(
					'pushToken'	=> $pushToken,
					'lat'		=> $lat,
					'lng'		=> $lng,
					'sessID'	=> $sessionID
				);
				
            	$userID = $this->user_auth_model->create_user($newUser);
            	
            	$this->load->library('session');
            	
            	$sessionData = array
				(
					'userID'	=> $userID,
					'sessID'	=> $sessionID,
					'loggedIn'	=> true
				);
				
				$this->session->set_userdata($sessionData);
				
				$response['userID'] = $userID;
            	
            	$response['reports'] = array();
				
				$response['requestStatus'] = 'OK';
				
				
            }
        }
        else
        {
	        $response['requestStatus'] = 'NOK1';
        }
        
        echo json_encode($response);

	} //End public function login
	
	
	
	
	
	
	public function get_worker_name()
	{
		/*
if($this->session_is_valid())
		{
			echo $this->session->userdata('workerName');
		}
		else
		{
			echo 'NOK2'; 
		}
*/
		$this->load->library('session');
		echo json_encode($this->session->all_userdata());
	}
	
	public function logout()
	{
		$this->logout();
		$response['requestStatus'] = 'LoggedOut';		
		
		echo json_encode($response);
	}
	
	public function test()
	{
		$this->load->library('session');
		echo $this->session->userdata('userID');
	}
	
	
	
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */













