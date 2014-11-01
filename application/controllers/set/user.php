<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


require_once(BASEPATH . '../application/libraries/TwitterAPIExchange.php');

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
		$rpu		= $this->input->post('rpu');
		$email		= $this->input->post('email');
		$twitter	= $this->input->post('twitter');

		error_reporting(E_ALL);
ini_set('display_errors', 1);
		
		
		if($userID && $lat && $lng && $type && $subType && $desc && $city && $rpu && ($email || $twitter))
		{
			$this->load->model('set/set_user');
            
            $date = new DateTime();
			$timestamp = $date->format('Y-m-d H:i:s');
			
            $uniqID = uniqid();
            
            $newReport = array
            (
            	'userID'			=> $userID,
            	'rpu'				=> $rpu,
            	'lat'				=> $lat,
            	'lng'				=> $lng,
            	'type'				=> $type,
            	'subType'			=> $subType,
            	'desc'				=> $desc,
            	'city'				=> $city,
            	'reportTicket'		=> $uniqID,
            	'email'				=> $email,
            	'twitter'			=> $twitter,
            	'creationDate'		=> $timestamp,
            	'lastUpdate'		=> $timestamp,
            	'publicComments' 	=> json_encode(array()),
            	'privateComments'	=> json_encode(array())	
            );    	
            
            $this->set_user->report($newReport);

            $this->report_successfully_created_notification($email,$twitter,$uniqID);
           
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
        	        	
        	$response['reportID'] = $uniqID;	
        	$response['requestStatus'] = 'OK';	
		}
		else
		{
			$response['requestStatus'] = 'NOK1';
		}
		
		echo json_encode($response);
	}
	
	private function report_successfully_created_notification($email,$twitter,$reportTicket)
	{
		if($email)
        {
       		if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) 
       		{
       			$this->send_report_email($email,"Tu reporte #$reportTicket se ha creado exitosamente!");
       		}

       		else
       		{
       			//Do nothing, parameter is not an email.
       		}
        	
        }
        elseif ($twitter)
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
			    'status' => "@". $twitter . " Tu reporte #$reportTicket se creó exitosamente."
			);

			$twitter = new TwitterAPIExchange($settings);

			$twitter->buildOauth($url, $requestMethod)
			        ->setPostfields($postfields)
			        ->performRequest();
	    }
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */













