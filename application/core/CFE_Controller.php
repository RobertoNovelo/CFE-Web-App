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

	protected function send_report_email($email,$comment)
	{

		$data['comment'] =  $comment;

		$date = new DateTime();

		$data['date'] = $date->format('Y-m-d'); 

		$data['time'] = $date->format('H:i'); 

		$this->load->library('email');
				
		$config = array(
		    'protocol'  => 'smtp',
		    'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
		    'smtp_user' => 'AKIAJQEBYV6CQWDDLRMA',
		    'smtp_pass' => 'AkcJTy/jsFMy0Uu6gC0VPRVAuTNl3CpWwv+Lx7qZ4KH1',
		    'smtp_port' => 465,
		    'newline'   => "\r\n",
		    'mailtype' => 'html',
		    'smtp_crypto' => 'ssl'
		);
		
		$this->email->initialize($config);
		
	    $this->email->clear();
	
	    $this->email->to($email);
	    $this->email->from('hola@retofutbol.com', 'CFE');
	    $this->email->subject("Reporte de CFE");
		
		$msg = $this->load->view('estatus_reporte',$data,TRUE);
		
		$this->email->message($msg);
		$this->email->send();
	}
	
}