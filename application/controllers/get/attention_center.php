<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class attention_center extends CFE_Controller {

	/**
	 * Get attention center controller.
	 * 
	 * This controller will process queries demanding information and location of attention centers.
	 *
	 * Maps to the following URL:
	 * 		/get/attention_center.php
	 *
	 */
	
	public function centers()
	{
		$this->load->model('get/get_centers');

		$centers = $this->get_centers->get_center_info();

		echo json_encode($centers);
	}
}

/* End of file attention_center.php */
/* Location: ./application/controllers/get/attention_center.php */
