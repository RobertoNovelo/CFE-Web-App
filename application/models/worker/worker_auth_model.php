<?php
class worker_auth_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function find_user_by_user_name($userName)
	{
		$this->db->where('userName',$userName);
		$this->db->select('CONCAT(name, " ", fLastName, " ", sLastName) AS workerName', FALSE);
		$this->db->select('id');
		$this->db->select('password');
		return $this->db->get('worker_data')->row();
	}
	
	function set_new_sess_id($userID,$sessID)
	{
		$this->db->where('id',$userID);
		$this->db->set('sessID',$sessID);
		$this->db->update('worker_data');
	}
	
	function create_worker($worker)
	{
		$this->db->insert('worker_data',$worker);
	}
	
	function get_sess_id($userID)
	{
		$this->db->where('id',$userID);
		return $this->db->get('worker_data')->row()->sessID;
	}
	
	function set_push_id($userID,$pushID)
	{
		$this->db->where('id',$userID);
		$this->db->set('pushToken',$pushID);
		$this->db->update('worker_data');
	}
	
}