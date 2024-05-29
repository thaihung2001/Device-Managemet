<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class InventoryModel  extends CI_Model
{
    function insertInventoryHistory($data)  //thêm mới vào bảng inventory_history (thêm hoặc cập nhật dữ liệu ở bảng inventory)
    {
        $data_inventory_history = array(
            'device_id' => $data['device_id'],
            'branch_id_recieve' => $data['branch_id_recieve'],
            'branch_id_send' => $data['branch_id_send'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'note' => '',
            'created_by' => $data['created_by'],
        );
        //$this->db->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;');
        $this->db->trans_start();

        //thêm mới vào bảng inventory_history
        $this->db->insert('inventory_history', $data_inventory_history);

        // Kiểm tra sự tồn tại của device_id và branch_id trong bảng inventory
        $this->db->select('*');
        $this->db->from('inventory');
        $this->db->where('device_id', $data_inventory_history['device_id']);
        $this->db->where('branch_id', $data_inventory_history['branch_id_recieve']);
        $isset = $this->db->get();
        if ($isset->num_rows() > 0) {
            //khóa hàng
            $this->db->query("SELECT * FROM inventory WHERE device_id = ? AND branch_id = ? FOR UPDATE", array($data_inventory_history['device_id'], $data_inventory_history['branch_id_recieve']));
            //sleep(30);
            // Cập nhật dữ liệu bảng inventory
            $this->db->set('quantity', 'quantity + ' . (int) $data_inventory_history['quantity'], FALSE);
            $this->db->where('device_id', $data_inventory_history['device_id']);
            $this->db->where('branch_id', $data_inventory_history['branch_id_recieve']);
            $this->db->update('inventory');
        } else {
            // Thêm mới dữ liệu vào bảng inventory
            $data_inventory = array(
                'device_id' => $data_inventory_history['device_id'],
                'branch_id' => $data_inventory_history['branch_id_recieve'],
                'quantity' => $data_inventory_history['quantity'],
                'status' => $data['status'],
            );
            $this->db->insert('inventory', $data_inventory);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }
    function ExportAndImport($data) //Thêm mới vào bảng inventory_history (cập nhật số lượng ở bảng inventory)
    {
        $data_import_export = array(
            'device_id' => $data['device_id'],
            'branch_id_recieve' => $data['branch_id_recieve'],
            'branch_id_send' => $data['branch_id_send'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'note' => $data['note'],
            'created_by' => $data['created_by'],
        );
        //$this->db->query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;');
        $this->db->trans_start();
        //kiểm tra sự tồn tại của chi nhánh và thiết bị cấp đi trong bảng inventory
        $this->db->select('*');
        $this->db->from('inventory');
        $this->db->where('device_id', $data_import_export['device_id']);
        $this->db->where('branch_id', $data_import_export['branch_id_send']);
        $isset_branch_id_send = $this->db->get();
        if ($isset_branch_id_send->num_rows() > 0) {
            //thêm mới vào bảng inventory_history
            $this->db->insert('inventory_history', $data_import_export);

            //khóa hàng update số lượng gửi 
            $this->db->query("SELECT * FROM inventory WHERE device_id = ? AND branch_id = ? FOR UPDATE", array($data_import_export['device_id'], $data_import_export['branch_id_send']));
            sleep(30);

            //trừ số lượng  nơi gửi
            $this->db->set('quantity', 'quantity - ' . (int) $data_import_export['quantity'], FALSE);
            $this->db->where('device_id', $data_import_export['device_id']);
            $this->db->where('branch_id', $data_import_export['branch_id_send']);
            $this->db->update('inventory');

            //kiểm tra sự tồn tại của chi nhánh và thiết bị đc cấp trong bảng inventory
            $this->db->select('*');
            $this->db->from('inventory');
            $this->db->where('device_id', $data_import_export['device_id']);
            $this->db->where('branch_id', $data_import_export['branch_id_recieve']);
            $isset = $this->db->get();
            if ($isset->num_rows() > 0) {
                //khóa hàng update số lượng nhận
                $this->db->query("SELECT * FROM inventory WHERE device_id = ? AND branch_id = ? FOR UPDATE", array($data_import_export['device_id'], $data_import_export['branch_id_recieve']));

                //cộng số lượng nơi nhận
                $this->db->set('quantity', 'quantity + ' . (int) $data_import_export['quantity'], FALSE);
                $this->db->where('device_id', $data_import_export['device_id']);
                $this->db->where('branch_id', $data_import_export['branch_id_recieve']);
                $this->db->update('inventory');
            } else {
                // thêm mới vào bảng inventory
                $data_inventory = array(
                    'device_id' => $data_import_export['device_id'],
                    'branch_id' => $data_import_export['branch_id_recieve'],
                    'quantity' => $data_import_export['quantity'],
                    'status' => $data['status'],
                );
                $this->db->insert('inventory', $data_inventory);
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    function barChart()
    {
        $this->db->select('SUM(quantity) as totalDevice, branch_id, branch.name');
        $this->db->from('inventory');
        $this->db->join('branch', 'branch.id = inventory.branch_id', 'right');
        $this->db->group_by('branch_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    function countGranted()
    {
        $this->db->select('SUM(quantity) as totalDevice');
        $this->db->from('inventory');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            return $result['totalDevice'];
        } else {
            return false;
        }
    }
    function getInventoryFromBranch($id)
    {
        $this->db->select('inventory.id as inventory_id, inventory.quantity, inventory.status, inventory.created_at, inventory.created_by, inventory.updated_at, inventory.updated_by, device.name as device_name, user.name as user_name');
        $this->db->from('inventory');
        $this->db->join('device', 'device.id=inventory.device_id');
        $this->db->join('user', 'user.id=inventory.created_by');
        $this->db->where('branch_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function updateInventoryAndDevice($inventory_id, $data)
    {
        // Lấy id trong bảng device 
        $this->db->select('device_id');
        $this->db->from('inventory');
        $this->db->where('id', $inventory_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $device_id = $result['device_id'];

            $this->db->trans_start();

            // Cập nhật bảng device
            $this->db->set('quantity_total', 'quantity_total + ' . (int) $data['quantity'], FALSE);
            $this->db->where('id', $device_id);
            $this->db->update('device');

            // Cập nhật bảng inventory
            $this->db->set('quantity', 'quantity - ' . (int) $data['quantity'], FALSE);
            $this->db->set('updated_by', $data['updated_by']);
            $this->db->where('id', $inventory_id);
            $this->db->update('inventory');

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
