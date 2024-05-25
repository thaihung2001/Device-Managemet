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
        $data['totalGrantedDevice'] = $this->InventoryModel->countGranted();
        $data['totalActive'] = $this->DeviceModel->countActiveDevice();
        $data['totalDeactive'] = $data['totalDevice'] - $data['totalActive'];

        //data modal "grant device to branch"
        $data['allDevice'] = $this->DeviceModel->getDevice(null, 0);
        $data['allBranch'] = $this->BranchModel->getBranch();

        $this->load->view('base/dashboard_header');
        $this->load->view('dashboard', $data);
        $this->load->view('base/barchart');
        $this->load->view('base/piechart');
        $this->load->view('base/dashboard_footer');
    }
    public function insertInventoryHistory()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('idAction', 'Type Action', 'trim|required');
            $this->form_validation->set_rules('idDevice', 'IDDevice', 'trim|required');
            if ($this->input->post('idAction') === 'export') {
                $this->form_validation->set_rules('idBranchFrom', 'Branch Name From', 'trim|required');
                $this->form_validation->set_rules('note', 'Note', 'required');
            }
            $this->form_validation->set_rules('idBranchTo', 'Branch Name To', 'trim|required');
            $this->form_validation->set_rules('numDevice', 'numDevice', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $type = $this->input->post('idAction');
                $device_id = $this->input->post('idDevice');
                $branch_id_recieve = $this->input->post('idBranchTo');
                $quantity = $this->input->post('numDevice');
                $branch_id_send = '';
                $note="";
                if ($type == "export") {
                    $branch_id_send = $this->input->post('idBranchFrom');
                    $note= $this->input->post('note');
                }
                $data = array(
                    'type' => $type,
                    'device_id' => $device_id,
                    'branch_id_recieve' => $branch_id_recieve,
                    'branch_id_send' => $branch_id_send,
                    'quantity' => $quantity,
                    'note' => $note,
                    'status' => 1,
                    'created_by' => $this->session->userdata('UserLoginSession')['id'],
                );
                //echo json_encode($data);return;
                //Phân loại nhãn hành động là thêm mới  (type= import)
                if ($type === "import") {
                    if ($this->InventoryModel->insertInventoryHistory($data)) {
                        echo json_encode(array("status" => true, "message" => "Cấp thiết bị mới cho chi nhánh thành công!"));
                    } else {
                        echo json_encode(array("status" => false, "message" => "Cấp thiết bị mới thất bại!"));
                    }
                } else if ($type === "export") { //Nếu nhãn hành động xuất kho  (type= export)
                    if($this->InventoryModel->ExportAndImport($data)){
                        echo json_encode(array("status" => true, "message" => "Xuất thiết bị từ chi nhánh thành công!"));
                    }else{
                        echo json_encode(array("status" => false, "message" => "Xuất thiết bị thất bại!"));
                    }
                }

                ///
            }
        }
    }
    public function updateInventory()
    {
    }
    public function barChart()
    {
        $data['barData'] = $this->InventoryModel->barChart();
        echo json_encode($data);
    }
    public function pieChart()
    {
        $data['pieData'] = $this->DeviceModel->pieChart();
        echo json_encode($data);
    }
    public function getInventoryFromBranch()
    {
        if ($this->input->method() === 'get') {
            $id_branch = $this->input->get('branch_id');
            $data['inventoryData'] = $this->InventoryModel->getInventoryFromBranch($id_branch);
            if ($data['inventoryData'] != FALSE) {
                echo json_encode(array("status" => true, 'data' =>  $data['inventoryData']));
            } else {
                echo json_encode(array("status" => false, "message" => "Không có dữ liệu."));
            }
        }
    }
    function revokeDeviceFromInventory()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('inventoryId', 'inventoryId', 'trim|required');
            $this->form_validation->set_rules('deviceRevokeQuantity', 'Device Quantity', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $id = $this->input->post('inventoryId');
                $quantity = $this->input->post('deviceRevokeQuantity');
                $data = array(
                    'quantity' => $quantity,
                    'updated_by' => $this->session->userdata('UserLoginSession')['id'],
                );

                $result = $this->InventoryModel->updateInventoryAndDevice($id, $data);
                if ($result) {
                    echo json_encode(array("status" => true,));
                } else {
                    echo json_encode(array("status" => false,));
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
