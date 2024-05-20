<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class DeviceModel  extends CI_Model
{
    function insertDevice($data)
    {
        $success = $this->db->insert('device', $data);
        if ($success) {
            return true;
        } else {
            return false;
        }
    }
    function updateDevice($id, $data)
    {
        $this->db->where('id', $id);
        $success = $this->db->update('device', $data);
        if ($success) {
            return true;
        } else {
            return false;
        }
    }
    function deleteDevice($id)
    {
        $result = $this->db->where('id', $id)->delete('device');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function countTotal()
    {
        return $this->db->count_all('device');
    }
    function getDevice($limit = null, $offset = 0)
    {
        $this->db->order_by('id', 'DESC');
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('device');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    function getSearchDevice($perPage, $start_index, $search_text=null)
    {   
        if($perPage !='' && $start_index != '')
        {
            $this->db->limit($perPage, $start_index);
        }
        if($search_text !=NULL)
        {
            $this->db->like('name',$search_text, 'both');
            $this->db->or_like('type',$search_text, 'both');
            $this->db->or_like('description',$search_text, 'both');
        }
        $query = $this->db->get('device');
        return $query->result_array();
    }
}
