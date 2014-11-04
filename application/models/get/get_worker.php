<?php
class get_worker extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function reports($workerID)
	{
		$this->db->where('workerID', $workerID);
		$this->db->where('active', 1);
		$this->db->select('id, reportTicket AS reportID,lat,lng,type,subType,desc,publicComments,privateComments,status,creationDate,lastUpdate');
		return $this->db->get('report_data')->result();
	}
	
	public function name($workerID)
	{
		$this->db->where('id', $workerID);
		$this->db->select('CONCAT(name, " ", fLastName, " ", sLastName) AS workerName', FALSE);
		return $this->db->get('worker_data')->row()->workerName;
	}

	public function push_tokens()
	{
		$this->db->select('pushToken');
		$this->db->where('pushToken is not null');
		return $this->db->get('worker_data')->result_array();
	}
}