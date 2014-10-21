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
        $userName	= $this->input->post('userName');
        $password	= $this->input->post('password');
        $pushID		= $this->input->post('pushID');

        $key		= 'nkobvcevl7o87dfho9386qrho6b7eorato323kd9';
        
        //Validate inputs used when session==1;
        if ($userName && $password)
        {
            $this->load->model('worker/worker_auth_model');
            $user = $this->worker_auth_model->find_user_by_user_name($userName);

            if($user)
            {
                $decryptedPassword =  rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($user->password), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

                if($password == $decryptedPassword)
                {
                	
	                $this->load->library('session');
	                
                	$sessionID = uniqid();
                
                	$sessionData = array
					(
						'userID'	=> $user->id,
						'sessID'	=> $sessionID,
						'loggedIn'	=> true,
						'workerName'=> $user->workerName
					);
					
					$this->session->set_userdata($sessionData);
					
					$this->worker_auth_model->set_new_sess_id($user->id,$sessionID);
					
                	$this->load->model('get/get_worker');
                	
                	$this->load->model('set/set_worker');
                	
					if($pushID)
					{
						$this->set_worker->push_id($user->id, $pushID);
					}
					
                	$response['workerName'] = $user->workerName;
                	$response['userID'] = $user->id;
                	
                	$response['reports'] = array();
                	
                	$userReports = $this->get_worker->reports($user->id);
		        	
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
                	$response['requestStatus'] = 'NOK2';
                }
            }
            else
            {
                $response['requestStatus'] = 'NOK2';
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













