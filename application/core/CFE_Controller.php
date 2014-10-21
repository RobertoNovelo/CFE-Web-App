<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CFE_Controller extends CI_Controller {
	
	public function session_is_valid()
	{
		$this->load->library('session');
		
		$userIsLoggedIn = $this->session->userdata('loggedIn');
		
		if($userIsLoggedIn)
		{
			$this->load->model('worker/worker_auth_model');
			
			$sessID = $this->worker_auth_model->get_sess_id($this->session->userdata('userID'));
			
			if($sessID == $this->session->userdata('sessID'))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}
	
	public function logout()
	{
		$this->load->library('session');
		$this->session->sess_destroy();
	}
	
}