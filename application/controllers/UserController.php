<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct() {
        parent::__construct();
		//check login
		if($this->session->userdata('UserLoginSession')){
            redirect(site_url('dashboard'));
        }
		$this->load->database();
		$this->load->model('UserModel');
    }
	public function index()
	{
		//$this->load->view('welcome_message');
		$this->load->view('base/header.php');
		$this->load->view('login');
		$this->load->view('base/footer.php');
	}
	public function checkLogin()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->form_validation->set_rules('email','Email','trim|required');
			$this->form_validation->set_rules('password','PassWord','trim|required');
			if($this->form_validation->run()==TRUE){
				$email=$this->input->post('email');
				$pass=$this->input->post('password');
				$pass=sha1($pass);
				$data=array(
					'email'=> $email,
					'password' => $pass,
				);
				$status= $this->UserModel->checkLogin($data);
				if ($status) {
					$session_data=array(
						'id' => $status['id'],
						'username'=> $status['name'],
						'email'=> $status['email']
					);
				$this->session->set_userdata('UserLoginSession',$session_data);
				echo json_encode(array("status" => true, "message" =>"Đúng thông tin"));
				
				}else{
					echo json_encode(array("status" => false, "message" =>"Sai thông tin đăng nhập!!!"));
				}
			}
		}
	}
}
