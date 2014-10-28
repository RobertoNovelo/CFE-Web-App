<?php
class admin_data extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function get_failures()
	{
		$this->db->select('id as reportID');
		$this->db->where('type',1);
		$failureIDs = $this->db->get('report_data')->result();
	
		$count  = count($failureIDs);
		
		if($count)
		{
			$failures = array();
			
			for($i=0;$i<$count;$i++)
			{	
				$this->db->select('CONCAT(worker_data.name, " ", worker_data.fLastName, " ", worker_data.sLastName) AS workerName', FALSE);
				$this->db->select('report_data.reportTicket,report_data.lat,report_data.lng,report_data.subType,report_data.desc, report_data.publicComments,report_data.privateComments,report_data.status,report_data.creationDate,report_data.lastUpdate');
				$this->db->where('report_data.id',$failureIDs[$i]->reportID);
				$this->db->join('worker_data', 'report_data.workerID = worker_data.id', 'left');
				
				$reportData = $this->db->get('report_data')->row();
				
				$key = "Falla: " . $reportData->reportTicket;
				$reportData->category	= "Reportes";
				$reportData->dataType	= 1;
				
				$failures[$key]	= $reportData;
				
			}
			
			return $failures;
		}	
	}
	
	function get_issues()
	{
		$this->db->select('id as reportID');
		$this->db->where('type',2);
		$issueIDs = $this->db->get('report_data')->result();
	
		$count  = count($issueIDs);
		
		$issues = array();
		
		if($count)
		{
			for($i=0;$i<$count;$i++)
			{	
				$this->db->select('CONCAT(worker_data.name, " ", worker_data.fLastName, " ", worker_data.sLastName) AS workerName', FALSE);
				$this->db->select('report_data.reportTicket,report_data.lat,report_data.lng,report_data.subType,report_data.desc, report_data.publicComments,report_data.privateComments,report_data.status,report_data.creationDate,report_data.lastUpdate');
				$this->db->where('report_data.id',$issueIDs[$i]->reportID);
				$this->db->join('worker_data', 'report_data.workerID = worker_data.id', 'left');
				
				$issueData = $this->db->get('report_data')->row();
				
				$key = "Queja: " . $issueData->reportTicket;
				$issueData->category ="Reportes";
				$issueData->dataType	= 2;
				
				$issues[$key]	= $issueData;
				
			}
		}
			
		return $issues;
	}
	
	function get_workers()
	{
		$this->db->select('id as workerID');
		$workerIDs = $this->db->get('worker_data')->result();
	
		$count  = count($workerIDs);
		
		$workers = array();
		
		if($count)
		{
			
			for($i=0;$i<$count;$i++)
			{	
				$this->db->select('id as workerID,lat,lng');
				$this->db->select('CONCAT(name, " ", fLastName, " ", sLastName) AS workerName', FALSE);
				$this->db->where('id',$workerIDs[$i]->workerID);
				
				$workerData = $this->db->get('worker_data')->row();
				
				$key = "Empleado: " . $workerData->workerName;
				$workerData->category ="Empleados";
				$workerData->dataType	= 3;
				
				$workers[$key]	= $workerData;
				
			}
		}
			
		return $workers;
	}
	
	function get_total_failures()
	{
		$this->db->where('type', 1);
		return $this->db->count_all_results('report_data');
		
	}
	
	function get_total_issues()
	{
		$this->db->where('type', 2);
		return $this->db->count_all_results('report_data');
		
	}
	
	function get_total_workers()
	{
		return $this->db->count_all_results('worker_data');
	}
}