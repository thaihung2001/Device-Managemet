<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class InventoryModel  extends CI_Model
{
function insertInventory($data)
    {   
        $success = $this->db->insert('inventory', $data);
        if ($success) {
            return true;
        } else {
            return false;
        }
    }
}