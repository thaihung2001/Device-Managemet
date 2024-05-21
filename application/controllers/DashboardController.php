<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
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
        $this->load->model('UserModel');
        $this->load->model('BranchModel');
        $this->load->model('DeviceModel');
        $this->load->model('InventoryModel');
    }
    public function index()
    {
        //data header dashboard
        $data['totalBranch'] = $this->BranchModel->countTotal();
        $data['totalDevice'] = $this->DeviceModel->countTotal();
        // $data['totalGrantedDevice']=$this->InventoryModel->countGranted();
        $data['totalGrantedDevice'] = 0;
        $data['totalActive'] = $this->DeviceModel->countActiveDevice();
        $data['totalDeactive'] = $data['totalDevice'] - $data['totalActive'];

        //data modal "grant device to branch"
        $data['allDevice']= $this->DeviceModel->getDevice(null,0,true);
        $data['allBranch']=$this->BranchModel->getBranch();

        $this->load->view('base/dashboard_header');
        $this->load->view('dashboard', $data);
        $this->load->view('base/barchart');
        $this->load->view('base/piechart');
        $this->load->view('base/dashboard_footer');
    }
    public function insertInventory()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nameDevice', 'Device Name', 'trim|required');
            $this->form_validation->set_rules('idDevice', 'IDDevice', 'trim|required');
            $this->form_validation->set_rules('idBranch', 'Branch Name', 'trim|required');
            $this->form_validation->set_rules('numDevice', 'numDevice', 'trim|required');
           
            if ($this->form_validation->run() == TRUE) {
                $device_id = $this->input->post('idDevice');
                $branch_id = $this->input->post('idBranch');
                $quantity = $this->input->post('numDevice');
               
                $data = array(
                    'device_id' => $device_id,
                    'branch_id' => $branch_id,
                    'quantity' => $quantity,
                    'status' => 1,
                    'created_by' => $this->session->userdata('UserLoginSession')['id'],
                );
                if ($this->InventoryModel->insertInventory($data)) {
                    echo json_encode(array("status" => true, "message" => "Cấp thiết bị cho chi nhánh thành công!"));
                } else {
                    echo json_encode(array("status" => false, "message" => "Cấp thiết bị thất bại!"));
                }
            }
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('UserLoginSession');
        redirect(site_url('login'));
    }
}
