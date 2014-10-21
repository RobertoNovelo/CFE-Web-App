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
		$this->db->where('id', $reportID);
		$this->db->where('active', 1);
		
		if ($this->db->count_all_results('report_data') > 0)
		{
			$this->db->where('id', $reportID);
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
		$this->db->where('id', $reportID);
		$this->db->where('active', 1);
		
		if ($this->db->count_all_results('report_data') > 0)
		{
			$this->db->where('id', $reportID);
			$this->db->where('active', 1);
			return $this->db->get('report_data')->row()->privateComments;
		}
		else
		{
			return false;
		}
		
	}
}