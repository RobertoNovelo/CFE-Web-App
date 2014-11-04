<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class report extends CFE_Controller {

	/**
	 * Remove report controller.
	 * 
	 * This controller will make requested report inactive.
	 *
	 * Maps to the following URL:
	 * 		/remove/report.php
	 *
	 */
	
	public function index()
	{
		$this->load->model('remove/remove_report');

		$this->remove_report->by_report_ticket($this->input->post('reportTicket'));

		$response['ok'] = true;

		echo json_encode($response);
	}
}

/* End of file attention_center.php */
/* Location: ./application/controllers/get/attention_center.php */
