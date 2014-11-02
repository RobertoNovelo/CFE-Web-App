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

	protected function CFE_ObtenerEstados()
	{
		$AccesoCliente = new stdClass();

		$AccesoCliente->UsuarioMovil		=	"usrReto071";
		$AccesoCliente->PasswordMovil	=	"@R3t0C3r053t3nt4yUn0@";
		$AccesoCliente->SistemaOperativo	=	"Ubuntu";
		$AccesoCliente->VersionSO		=	"14.04.1 LTS";
		$AccesoCliente->TipoEquipo		=	"AWS EC2 Instance";
		$AccesoCliente->ModeloEquipo		=	"t2 micro";
		$AccesoCliente->ResolucionEquipo	=	"not available";
		$AccesoCliente->IP				=	"54.69.204.188";
		$AccesoCliente->Ubicacion		=	"not available";

		$hashString = "usrReto071@R3t0C3r053t3nt4yUn0@Ubuntu14.04.1 LTSAWS EC2 Instancet2 micronot available54.69.204.188not availablevlw3xMqy9LNjQMs5rE4z";

		$AccesoCliente->Hash				=	sha1($hashString);


		$client = new SoapClient("http://aplicaciones.cfe.gob.mx/WebServices/CFEMovil/CFEMovil.svc?wsdl");

		// $client->__setLocation('http://aplicaciones.cfe.gob.mx/WebServices/CFEMovil/CFEMovil.svc?wsdl/basic');

		$response = $client->ObtenerEstados(array( "Acceso" => $AccesoCliente));

		echo json_encode($response);

		// echo($client);

		// $CFE_ObtenerEstadosParams = array
		// (
		// 	"Acceso" => $AccesoCliente
		// );

		// return $this->send_http_request(CFE_URLS::SEL_ObtenerEstados,$CFE_ObtenerEstadosParams);

	}


	private function send_http_request($url , $data) 
	{
	    $request = json_encode($data);
	 
	    $ch = curl_init();

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	 
	    $response = curl_exec($ch);
	    $info = curl_getinfo($ch);
	    curl_close($ch);

	    return $response;
	}


	
}

abstract class CFE_URLS
{
	const privateKey = "vlw3xMqy9LNjQMs5rE4z";
    const SEL_ObtenerEstados = "http://aplicaciones.cfe.gob.mx/WebServices/CFEMovil/CFEMovil/ObtenerEstados";
}