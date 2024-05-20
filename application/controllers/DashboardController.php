<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        //check login
        if(!$this->session->userdata('UserLoginSession')){
            redirect(site_url('login'));
        }
        //load database
		$this->load->database();
		$this->load->model('UserModel');
        $this->load->model('BranchModel');
        $this->load->model('DeviceModel');
    }
	public function index()
	{
        $data['totalBranch']=$this->BranchModel->countTotal();
        $data['totalDevice']=$this->DeviceModel->countTotal();
        $this->load->view('base/dashboard_header');
        $this->load->view('dashboard',$data);
        $this->load->view('base/dashboard_footer');
	}
    public function logout()
	{
		$this->session->unset_userdata('UserLoginSession');
        redirect(site_url('login'));
	}
}