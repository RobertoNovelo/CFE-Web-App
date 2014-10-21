<?php
class set_user extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function report($newReport)
	{
		$this->db->insert('report_data',$newReport);
	}
}