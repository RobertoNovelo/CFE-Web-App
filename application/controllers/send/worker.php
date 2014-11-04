<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class worker extends CFE_Controller {


    public function push_message_to_all()
    {
        $this->push_to_all_workers($this->input->post('pushMessage'));

        $response['ok'] = true;

        echo json_encode($response);
    }   
    
    
}

/* End of file user.php */













