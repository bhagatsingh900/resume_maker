<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_controller extends CI_Controller
	{
	
		public function __construct()
			{
				parent::__construct();
				if($this->uri->segment(1)!='logout'){				
					
					if(!empty($this->session->userdata('admin_user_id')))
					{
					      // redirect(base_url().'admin/home');
					}
				}
			}
				
		public function index()
			{
				$this->load->view('admin/login');
			}
		
		public function login_check()
			{
				$_POST['type']="admin";
				$login=$this->customModel->selectOne('users',$_POST);		 
				if(!empty($login))
				{
						$arraydata = array(
								'admin_user_id'  => $login[0]->id,
								'email'     => $login[0]->email,
								'logged_in' => true
						);
					 $this->session->set_userdata($arraydata);
					 redirect(base_url('admin/home'));
				}else{
					$this->session->set_flashdata('msg', 'Wrong Login Credentials');
					 redirect(base_url('login'));
				}	  
			}
		
		public function word_example()
			{
				$this->load->view('admin/word_ex');
			}
			
		public function logout()
		{
			$this->session->sess_destroy();
			redirect(base_url('login'));
		}
	}
