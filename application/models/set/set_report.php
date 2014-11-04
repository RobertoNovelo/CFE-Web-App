<?php
class set_report extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function status($reportID, $status)
	{
		$this->db->where('reportTicket',$reportID);
		$this->db->set('status',$status);
		$this->db->update('report_data');
	}
}