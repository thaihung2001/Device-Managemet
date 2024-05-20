<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class BranchModel  extends CI_Model{
    function getBranch(){
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('branch');
        if($query->num_rows() > 0){
            return $query->result_array();
        } else {
            return false;
        }
    }
    function insertBranch($data)
    {
        $success = $this->db->insert('branch',$data);
        if ($success) {
            return true;
        } else {
            return false;
        }
    }
    function updateBranch($id,$data)
    {   
        $this->db->where('id', $id);
        $success =  $this->db->update('branch', $data);
        if ($success) {
            return true;
        } else {
            return false;
        }
    }
    function deleteBranch($id)
    {
        $result= $this->db->where('id',$id)->delete('branch');
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function checkName($data)
    {
        $query= $this->db->where('name',$data['name'])->get('branch');
        if($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }
    function countTotal()
    {
        return $this->db->count_all('branch');
    }
}