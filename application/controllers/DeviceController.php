<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DeviceController extends CI_Controller
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
        $this->load->model('DeviceModel');

        //load lib pagination
        $this->load->library('pagination');
    }
    public function index()
    {
        $perPage = 5;
        $page = 0;
        if ($this->input->get('page')) {
            $page = $this->input->get('page');
        }
        $start_index = 0;
        if ($page != 0) {
            $start_index = $perPage * ($page - 1);
        }
        // Cấu hình phân trang
        $config['enable_query_strings'] = true;
        $config['use_page_numbers'] = true;
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = true;
        $config['base_url'] = base_url('device');
        $config['total_rows'] = $this->DeviceModel->countTotal();
        $config['per_page'] = $perPage;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);

        if ($this->input->get('search') != NULL) // nếu nhập ký tự tìm kiếm 
        {
            $search_text = $this->input->get('search');
            $data['results'] = $this->DeviceModel->getSearchDevice($perPage, $start_index, $search_text);
        } else { // load trang bình thường không tìm kiếm
            $data['results'] = $this->DeviceModel->getDevice($config['per_page'], $start_index);
        }
        $data['links'] = $this->pagination->create_links();

        $this->load->view('base/dashboard_header');
        $this->load->view('device', $data);
        $this->load->view('base/dashboard_footer');
    }
    public function loadDevice()
    {
        $data['allData'] = $this->DeviceModel->getDevice(5, 0);
        if ($data['allData'] != FALSE) {
            echo json_encode(array("status" => true, "data" => $data['allData']));
        }
    }
    public function insertDevice()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Device Name', 'required');
            $this->form_validation->set_rules('type', 'Device Type', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('date_buy', 'Date of Purchase', 'required');
            $this->form_validation->set_rules('active', 'Active', 'required');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('name'),
                    'type' => $this->input->post('type'),
                    'description' => $this->input->post('description'),
                    'date_buy' => $this->input->post('date_buy'),
                    'active' => $this->input->post('active')
                );
                if ($this->DeviceModel->insertDevice($data)) {
                    echo json_encode(array("status" => true, "message" => "Thêm thiết bị mới thành công!"));
                } else {
                    echo json_encode(array("status" => false, "message" => "Thêm thiết bị thất bại!"));
                }
            } else {
                echo json_encode(array("status" => false, "message" => validation_errors()));
            }
        }
    }
    public function updateDevice()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('deviceId', 'Id', 'trim|required');
            $this->form_validation->set_rules('deviceEditName', 'Device Name', 'required');
            $this->form_validation->set_rules('deviceEditType', 'Device Type', 'required');
            $this->form_validation->set_rules('deviceEditDescription', 'Description', 'required');
            $this->form_validation->set_rules('deviceEditDate', 'Date of Purchase', 'required');
            $this->form_validation->set_rules('deviceEditActive', 'Active', 'required');
            if ($this->form_validation->run() == TRUE) {
                $id = $this->input->post('deviceId');
                $name = $this->input->post('deviceEditName');
                $type = $this->input->post('deviceEditType');
                $date = $this->input->post('deviceEditDate');
                $description = $this->input->post('deviceEditDescription');
                $active = $this->input->post('deviceEditActive');
                $data = array(
                    'name' => $name,
                    'type' => $type,
                    'description' => $description,
                    'date_buy' => $date,
                    'active' => $active,
                );
                if ($this->DeviceModel->updateDevice($id, $data)) {
                    echo json_encode(array("status" => true, "message" => "Cập nhật thành công!"));
                } else {
                    echo json_encode(array("status" => false, "message" => "Cập nhật thất bại!"));
                }
            }
        }
    }
    public function deleteDevice()
    {
        if ($this->input->method() === 'delete') {
            $id = $this->input->input_stream('id');
            if ($this->DeviceModel->deleteDevice($id)) {
                echo json_encode(array("status" => true, "message" => "Xóa thành công!"));
            } else {
                echo json_encode(array("status" => false, "message" => "Xóa thất bại!"));
            }
        }
    }
}
