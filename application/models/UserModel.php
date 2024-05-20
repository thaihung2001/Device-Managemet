<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
class UserModel  extends CI_Model{
    function checkLogin($data){
        $query= $this->db->where('email',$data['email'])->where('password',$data['password'])->get('user');
         if($query->num_rows()>0){
             return $query->row_array();
         }else{
             return false;
         }
     }
}