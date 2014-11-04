<?php
class get_report extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function all_by_city($city)
	{
		$this->db->where('city', $city);
		$this->db->where('active', 1);
		$this->db->select('id,lat,lng,type,subType,desc,publicComment,status,creationDate,lastUpdate');
		return $this->db->get('report_data')->result();
	}
	
	public function publicComment_by_id($reportID)
	{
		$this->db->where('reportTicket', $reportID);
		$this->db->where('active', 1);
		
		if ($this->db->count_all_results('report_data') > 0)
		{
			$this->db->where('reportTicket', $reportID);
			$this->db->where('active', 1);
			return $this->db->get('report_data')->row()->publicComments;
		}
		else
		{
			return false;
		}
		
	}
	
	public function privateComment_by_id($reportID)
	{
		$this->db->where('reportTicket', $reportID);
		$this->db->where('active', 1);
		
		if ($this->db->count_all_results('report_data') > 0)
		{
			$this->db->where('reportTicket', $reportID);
			$this->db->where('active', 1);
			return $this->db->get('report_data')->row()->privateComments;
		}
		else
		{
			return false;
		}
		
	}

	public function get_data_by_reportID($reportID)
	{
		$this->db->select('user_data.pushToken');
		$this->db->select('report_data.reportTicket');

		$this->db->where_in('report_data.reportTicket',$reportID);

		$this->db->join('report_data', 'user_data.id = report_data.userID', 'left');

		return $this->db->get('user_data')->row();
	}

	function email_account($reportID)
	{
		$this->db->select('email');
		$this->db->where('email IS NOT NULL');
		$this->db->where('reportTicket',$reportID);

		if ($this->db->count_all_results('report_data') > 0)
		{
			$this->db->select('email');
			$this->db->where('email IS NOT NULL');
			$this->db->where('reportTicket',$reportID);



			return $this->db->get('report_data')->row()->email;
		}
		else
		{
			return false;
		}
	}

	function twitter_account($reportID)
	{
		$this->db->select('twitter');
		$this->db->where('twitter IS NOT NULL');
		$this->db->where('reportTicket',$reportID);

		if ($this->db->count_all_results('report_data') > 0)
		{
			$this->db->select('twitter');
			$this->db->where('twitter IS NOT NULL');
			$this->db->where('reportTicket',$reportID);

			return $this->db->get('report_data')->row()->twitter;
		}
		else
		{
			return false;
		}
	}

	function ticket_id($reportID)
	{
		$this->db->select('reportTicket');
		$this->db->where('reportTicket',$reportID);

		return $this->db->get('report_data')->row()->reportTicket;
	}

	function owner_push_token($reportTicket)
	{
		$this->db->select('userID');
		$this->db->where('reportTicket',$reportTicket);

		$userID =  $this->db->get('report_data')->row()->userID;

		$this->db->select('pushToken');
		$this->db->where('id',$userID);

		return $this->db->get('user_data')->row()->pushToken;
	}


}
