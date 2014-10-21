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
	
	public function position()
	{
		$workerID	= $this->input->post('workerID');
        $lat		= $this->input->post('lat');
        $lng		= $this->input->post('lng');
        
        if($workerID && $lat && $lng)
        {
	        $this->load->model('set/set_worker');
	        
	        $this->set_worker->position($workerID,$lat,$lng);
	        
        	$response['requestStatus'] = 'OK';	
        }
        else
        {
        	$response['requestStatus'] = 'NOK1';	
        }
        
        echo json_encode($response);
	}
	
	
	public function index()
	{
		$userName	= $this->input->post('userName');
        $password	= $this->input->post('password');
        $name		= $this->input->post('name');
        $fLastName	= $this->input->post('fLastName');
        $sLastName	= $this->input->post('sLastName');

        $key		= 'nkobvcevl7o87dfho9386qrho6b7eorato323kd9';
        
        
        //Validate inputs used when session==1;
        if ($userName && $password && $name && $fLastName && $sLastName)
        {
			$this->load->library('session');
        
            $this->load->model('worker/worker_auth_model');
            
            $user =$this->worker_auth_model->find_user_by_user_name($userName);

            if(!$user)
            {
            	$encryptedPass = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $password, MCRYPT_MODE_CBC, md5(md5($key))));
		
            	$newWorker = array
            	(
            		'userName'	=> $userName,
            		'password'	=> $encryptedPass,
            		'name'		=> $name,
            		'sessID'	=> uniqid(),
            		'fLastName'	=> $fLastName,
            		'sLastName'	=> $sLastName,
            	);
            	
            	$this->worker_auth_model->create_worker($newWorker);
            	
            	echo 'OK';
		
            }
            else
            {
	            echo 'NOK2';
            }
        }
        else
        {
	        echo 'NOK1';
        }
	}
	
	
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */













