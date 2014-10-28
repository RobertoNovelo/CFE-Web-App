<?php
class set_user extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function report($newReport)
	{
		$this->db->insert('report_data',$newReport);
	}
	
	function lat_lng($userID, $lat, $lng)
	{
		$this->db->where('id',$userID);
		$this->db->set('lat',$lat);
		$this->db->set('lng',$lng);
		$this->db->update('user_data');
	}
}