<?php
class get_centers extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function get_center_info()
	{
		$this->db->select('state');
		$this->db->select('city');
		$this->db->select('suburb');
		$this->db->select('address');
		$this->db->select('lat');
		$this->db->select('lng');
		$this->db->select('agencia');
		$this->db->select('cfmatico');
		$this->db->select('workDays');
		$this->db->select('workTime');

		$this->db->where('lat is not NULL',NULL,false);
		$this->db->where('lng is not NULL',NULL,false);

		return $this->db->get('attention_center_data')->result();
	}
}