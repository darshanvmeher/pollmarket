<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

   

//admin login
    public function get_admin_by_email($email)
{
    $this->db->where('email', $email);
    $this->db->where('user_type', 'admin');

    return $this->db->get('users_tbl')->row_array();
}



public function check_admin_phone($email, $phone_no)
{
    $this->db->where('email', $email);
    $this->db->where('phone_no', $phone_no);
    $this->db->where('user_type', 'admin');

    return $this->db->get('users_tbl')->row_array();
}

}



