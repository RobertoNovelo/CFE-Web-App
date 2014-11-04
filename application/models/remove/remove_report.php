<?php
class remove_report extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function by_report_ticket($reportTicket)
	{
		$this->db->where('reportTicket',$reportTicket);
		$this->db->set('active',0);
		$this->db->update('report_data');
	}
}