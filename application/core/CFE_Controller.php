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

	protected function CFE_ReporteFallas()
	{
		$string = 'usrReto071@R3t0C3r053t3nt4yUn0@iOS8.1IPhone6201.124.20.103375262054121usuariotmp@example.comFavor de revisar el serviciovlw3xMqy9LNjQMs5rE4z';

		$hash = sha1($string);

		$acceso = array(

				'UsuarioMovil'		=>	"usrReto071",
				'PasswordMovil'		=>	"@R3t0C3r053t3nt4yUn0@",
				'SistemaOperativo'	=>	"iOS",
				'VersionSO'			=>	"8.1",
				'TipoEquipo'		=>	"IPhone",
				'ModeloEquipo'		=>	"6",
				'Ip'				=>	"201.124.20.103",
				'Hash'				=>	$hash
			);

		$rpu = "375262054121";

		$correo = "usuariotmp@example.com";

		$observaciones  = "Favor de revisar el servicio";

		$TipoFalla = "08";

		$client = new SoapClient('http://aplicaciones.cfe.gob.mx/WebServices/CFEMovil/CFEMovil.svc?wsdl',array('trace' => true));
 
  		$response = $client->SELReporteFallas(array("Acceso"=>$acceso , "Rpu"=>$rpu , "Correo"=>$correo, "Observaciones" =>$observaciones, "TipoFalla" => $TipoFalla));

		return $response->SELReporteFallasResult->Folio;

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

