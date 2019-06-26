<?php
error_reporting(0);
use resume_builder\Libraries\REST_Controller; 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class User extends REST_Controller
	{
		  public function __construct()
		  {
				parent::__construct(); 
		 }
		
		public function users_get()
			{
					$data = $this->customModel->selectOne("users");
					//$this->response($data, REST_Controller::HTTP_OK);
					$dd = array('status' => "Success", "response_code" => 200, "message"=>"data fetched","result" => $data );
					$this->response($dd, 200);
			}
			
		public function signup_post()
		{
			$email=$this->input->post('email');
			$name=$this->post('name'); 
			$mobile=$this->input->post('mobile');
			$password=$this->input->post('password');
			$Device_token=$this->post('device_token');
			$chechEmail= $this->customModel->selectOne("users",array("email"=>$email));
			if(!empty($chechEmail))
			{
				$response = array('status' => "Failed", "response_code" => 400, "message"=>"Email Already Exist","result" => "" );
				$this->response($response, 400);
			}else{
				 $_POST['password']=encryptIt($password);
				 $_POST['otp']=mt_rand(100000,999999);
				 $_POST['type']="user";
				 $_POST['_token']=uniqid();
                 $insert_id=$this->customModel->insertData('users',$_POST);
				 $records=$this->customModel->selectOne('users',array("id"=>$insert_id));
                 $this->response(array("status" => "Success", "response_code" => 200,"message"=>"Signup Successfully", "result" =>$records), 200);
			}
		}
		
		public function login_post()
		{
			$email=$this->input->post('email');
			$password=$this->input->post('password');
			$chechEmail= $this->customModel->selectOne("users",array("email"=>$email,"password"=>encryptIt($password),"type"=>"user"));
			if(!empty($chechEmail))
			{
				$response = array('status' => "Success", "response_code" => 200, "message"=>"Login Successfully","result" => $chechEmail );
				$this->response($response, 200);
			}else{
				$response = array('status' => "Failed", "response_code" => 400, "message"=>"Wrong Login Credentials","result" => '' );
				$this->response($response, 400);
			}
		}
		
		public function templateList_get()
		{
			$data=$this->customModel->selectAll('templates',array("status"=>1));
			if(!empty($data))
			{
				$response = array('status' => "Success", "response_code" => 200, "message"=>"Templates List","result" => $data);
				$this->response($response, 200);
			}else{
				$response = array('status' => "Failed", "response_code" => 400, "message"=>"No Records","result" => '' );
				$this->response($response, 400);
			}
		}
		
		public function Gettemplate_post()
		{
			$tempid=$this->input->post('template_id');
			$records=$this->customModel->selectOne("template_section",array("template_id"=>$tempid));
			if(!empty($records))
			{
				$response = array('status' => "Success", "response_code" => 200, "message"=>"Templates List","result" => $records);
				$this->response($response, 200);
			}else{
				$response = array('status' => "Failed", "response_code" => 400, "message"=>"No Records","result" => '' );
				$this->response($response, 400);
			}
		}
		
	}
	
	