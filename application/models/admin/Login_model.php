<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {	 
	
	public function login_check()
	{
		print_r($_POST);
		echo base64_encode($this->input->post('password'));die; 
	}
}
