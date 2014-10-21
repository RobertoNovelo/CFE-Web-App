<?php
class set_worker extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function public_comment($reportID,$comment)
	{
		$this->db->where('id',$reportID);
		$this->db->set('publicComments',$comment);
		
		$date = new DateTime();
		$timestamp = $date->format('Y-m-d H:i:s');
		
		$this->db->set('lastUpdate',$timestamp);
		$this->db->update('report_data');
		
	}
	
	public function private_comment($reportID,$comment)
	{
		$this->db->where('id',$reportID);
		$this->db->set('privateComments',$comment);
		
		$date = new DateTime();
		$timestamp = $date->format('Y-m-d H:i:s');
		
		$this->db->set('lastUpdate',$timestamp);
		$this->db->update('report_data');
		
	}
	
	function position($workerID,$lat,$lng)
	{
		$this->db->where('id',$workerID);
		$this->db->set('lat',$lat);
		$this->db->set('lng',$lng);
		$this->db->update('worker_data');
	}
	
	function push_id($workerID, $pushID)
	{
		$this->db->where('id',$workerID);
		$this->db->set('pushID',$pushID);
		$this->db->update('worker_data');
	}
	
}