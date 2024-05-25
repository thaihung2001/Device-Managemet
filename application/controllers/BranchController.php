<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BranchController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check login
        if (!$this->session->userdata('UserLoginSession')) {
            redirect(site_url('login'));
        }
        //load database
        $this->load->database();
        $this->load->model('BranchModel');
    }
    public function index()
    {
        //echo $this->session->userdata('UserLoginSession')['username'];
        $this->load->view('base/dashboard_header');
        $data['allData'] = $this->BranchModel->getBranch();
        $this->load->view('branch', $data);
        $this->load->view('base/dashboard_footer');
    }
    public function loadBranch()
    {
        $data['allData'] = $this->BranchModel->getBranch();
        if($data['allData']!=FALSE){
            echo json_encode(array("status"=>true,"data"=> $data['allData']));
        }
    }
    public function insertBranch()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('createNameBranch', 'NameBranch', 'required');
            $this->form_validation->set_rules('createAddressBranch', 'AddressBranch', 'required');
            if ($this->form_validation->run() == TRUE) {
                $name = $this->input->post('createNameBranch');
                $address = $this->input->post('createAddressBranch');
                $data = array(
                    'name' => $name,
                    'address' => $address
                );
                if($this->BranchModel->checkName($data)){ //check isset name
                    echo json_encode(array("status" => false, "message" => "Tên chi nhánh bị trùng! Vui lòng nhập tên khác")); 
                }else{
                    if ($this->BranchModel->insertBranch($data)) {
                        $data['branchs']=$this->BranchModel->getBranch();
                        echo json_encode(array("status" => true, "message" => "Thêm thành công chi nhánh mới!", "branchs" => $data['branchs']));
                    } else {
                        echo json_encode(array("status" => false, "message" => "Thêm thất bại!"));
                    }
                }
            }
        }
    }
    public function updateBranch()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('branchId', 'Id', 'trim|required');
            $this->form_validation->set_rules('branchName', 'branchName', 'required');
            $this->form_validation->set_rules('branchAddress', 'branchAddress', 'required');
            if ($this->form_validation->run() == TRUE) {
                $id = $this->input->post('branchId');
                $name = $this->input->post('branchName');
                $address = $this->input->post('branchAddress');
                $data = array(
                    'name' => $name,
                    'address' => $address
                );
                if ($this->BranchModel->updateBranch($id, $data)) {
                    echo json_encode(array("status" => true, "message" => "Cập nhật thành công!"));
                } else {
                    echo json_encode(array("status" => false, "message" => "Cập nhật thất bại!"));
                }
            }
        }
    }
    public function deleteBranch()
    {
        if ($this->input->method() === 'delete') {
            $id = $this->input->input_stream('id');
            if ($this->BranchModel->deleteBranch($id)) {
                echo json_encode(array("status" => true, "message" => "Xóa thành công!"));
            } else {
                echo json_encode(array("status" => false, "message" => "Xóa thất bại!"));
            }
        }
    }
}
