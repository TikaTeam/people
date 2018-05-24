<?php
class tab extends \Framework\cli {
    function home(){
        $data= array(
            'title' => 'Tika',
        );

		$this->load->view('tab/header', $data);
		$this->load->view('tab/home');
		$this->load->view('tab/footer');
    }
}