<?php
class user_auth_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function find_user_by_push_token($pushToken)
	{
		$this->db->where('pushToken',$pushToken);
		$this->db->select('id');
		return $this->db->get('user_data')->row()->id;
	}
	
	function set_new_sess_id($userID,$sessID)
	{
		$this->db->where('id',$userID);
		$this->db->set('sessID',$sessID);
		$this->db->update('user_data');
	}
	
	function create_user($user)
	{
		$this->db->insert('user_data',$user);
		return $this->db->insert_id();
	}
	
	function get_sess_id($userID)
	{
		$this->db->where('id',$userID);
		return $this->db->get('user_data')->row()->sessID;
	}
	
	function set_push_id($userID,$pushID)
	{
		$this->db->where('id',$userID);
		$this->db->set('pushID',$pushID);
		$this->db->update('user_data');
	}
	
}