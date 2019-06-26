<?php

Class Home_controller extends CI_Controller
{
	
	 public function __construct()
    {
        parent::__construct();
        if(!is_logged_in())  
        {
         	redirect(base_url('login'));
        }
    }
	
	 public function index()
	 {
		$this->load->view('admin/common/header');
		$this->load->view('admin/common/sidebar');
		$this->load->view('admin/home');
		$this->load->view('admin/common/footer');
	 }
	 
	
}
?>