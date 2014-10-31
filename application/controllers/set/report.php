<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Defines for PushWoosh API
define('PW_AUTH', 'aDVeMECq0x8npwH7EzYdML8xzGNiJiN4wZf7c3drrhFUWAPrGYQCGROPkBihftilPHEcJOAzbt41O4vFJIuE');
define('PW_APPLICATION', '93E84-ECC19');

//Defines for Twitter API
// define('PW_AUTH', 'aDVeMECq0x8npwH7EzYdML8xzGNiJiN4wZf7c3drrhFUWAPrGYQCGROPkBihftilPHEcJOAzbt41O4vFJIuE');
// define('PW_APPLICATION', '93E84-ECC19');

require_once(BASEPATH . '../application/libraries/TwitterAPIExchange.php');

class report extends CFE_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function status()
	{
		$workerID	= $this->input->post('workerID');
        $reportID	= $this->input->post('reportID');
        $status		= $this->input->post('status');
        $session 	= $this->input->post('session'); //1 for mail, 2 for twitter
        $account 	= $this->input->post('account'); //mail or twitter depending on session

        //Validate inputs used when session==1;
        if ($workerID && $reportID && $status && $session && $account)
        {
        	$this->load->model('set/set_report');
        	
        	$this->set_report->status($reportID, $status);
        	
        	$this->load->model('get/get_report');
            
            $publicComment = json_decode($this->get_report->publicComment_by_id($reportID),TRUE);
            
        	$this->load->model('get/get_worker');
        	
        	$date = new DateTime();
			$timestamp = $date->format('Y-m-d H:i:s');
			
			switch($status)
			{
				case 1:
					$estado = "Pendiente";
				break;
				case 2:
					$estado = "En proceso";
				break;
				case 3:
					$estado = "Resuelto";
				break;
				default:
					$estado = "Cerrado";
				break;
			}
            
	        $publicComment[] = array
            (
            	'workerName'	=> $this->get_worker->name($workerID),
            	'comment'		=> "Se cambió el estado del reporte a $estado",
            	'date'			=> $timestamp
            );

            $data = $this->get_report->get_data_by_reportID($reportID);

            $pushToken = $data->pushToken;

            $reportTicket = $data->reportTicket;

            $msg = "El estado de su reporte #$reportTicket ha cambiado a $estado";

            $this->send_push($msg,$pushToken);

            $this->load->model('set/set_worker');
            
            $this->set_worker->public_comment($reportID,json_encode($publicComment));
            
	       // $response['requestStatus'] = 'OK';
            
            if($session == 1)
            {
           		if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$account)) 
           		{
           			$this->send_report_email($account,$msg);
           			$response['requestStatus'] = 'OK';
           		}

           		else
           		{
           			$response['requestStatus'] = 'NOK1';
           		}
            	
            }

            else
            {
            	$settings = array(
				    'oauth_access_token' => "2853549970-8I1dNqZZqXY1AohZAw3YGf8SfnJfqZCRm2jHNsA",
				    'oauth_access_token_secret' => "pAHzrLL79DKpRhhWWhyLni79pYOIb6lAMuEHa1BNVv7WT",
				    'consumer_key' => "U571bltELyhBGZHTTCZJqScat",
				    'consumer_secret' => "8HgZiefgum3E2FLgjpUh6R3ZAkJLqumaknfzqI0di6hwcoW2qz"
				);

				$url = 'https://api.twitter.com/1.1/statuses/update.json';
				$requestMethod = 'POST';


				$postfields = array(
				    'status' => '@$account El estatus de su reporte #$reportTicket a cambiado a $estado'
				);

				$twitter = new TwitterAPIExchange($settings);

				$twitter->buildOauth($url, $requestMethod)
				        ->setPostfields($postfields)
				        ->performRequest();

				 $response['requestStatus'] = 'OK';
		    }

        }

        else
        {
	        $response['requestStatus'] = 'NOK1';
        }
        
        echo json_encode($response);
	}


	private function send_push($message,$pushToken)
	{

		$this->pwCall('createMessage',[
	    'application' => PW_APPLICATION,
	    'auth' => PW_AUTH,
	    'notifications' => [
       					 		[
   								'send_date' => 'now',
        					 	'content' => $message,
       	   					 	'data' => ['custom' => 'json data'],
       	   					 	'devices'=>[$pushToken]
       							 ]
        					]
   		 				]
		);
	}


	private function pwCall($method , $data) 
	{
	    $url = 'https://cp.pushwoosh.com/json/1.3/' . $method;
	    $request = json_encode(['request' => $data]);
	 
	    $ch = curl_init();

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	 
	    $response = curl_exec($ch);
	    $info = curl_getinfo($ch);
	    curl_close($ch);
	}

	private function send_report_email($account,$comment)
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
			
			    $this->email->to($account);
			    $this->email->from('hola@retofutbol.com', 'CFE');
			    $this->email->subject("Reporte de CFE");
				
				$msg = $this->load->view('estatus_reporte',$data,TRUE);
				
				$this->email->message($msg);
				$this->email->send();
	}

	public function test()
	{
		$settings = array(
		    'oauth_access_token' => "2853549970-8I1dNqZZqXY1AohZAw3YGf8SfnJfqZCRm2jHNsA",
		    'oauth_access_token_secret' => "pAHzrLL79DKpRhhWWhyLni79pYOIb6lAMuEHa1BNVv7WT",
		    'consumer_key' => "U571bltELyhBGZHTTCZJqScat",
		    'consumer_secret' => "8HgZiefgum3E2FLgjpUh6R3ZAkJLqumaknfzqI0di6hwcoW2qz"
		);

		$url = 'https://api.twitter.com/1.1/statuses/update.json';
		$requestMethod = 'POST';


		$postfields = array(
		    'status' => '12345'
		);

		$twitter = new TwitterAPIExchange($settings);

		$twitter->buildOauth($url, $requestMethod)
		        ->setPostfields($postfields)
		        ->performRequest();
	}

}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */