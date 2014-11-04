<?php
class get_user extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function reports($userID)
	{
		$this->db->where('userID', $userID);
		$this->db->where('active', 1);
		$this->db->select('reportTicket AS id,lat,lng,type,subType,desc,publicComments,status,creationDate,lastUpdate');
		return $this->db->get('report_data')->result();
	}
}