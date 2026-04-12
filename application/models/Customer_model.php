<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

        public function get_customer_by_email($email)
{
    $this->db->where('email', $email);
    $this->db->where('user_type', 'customer');

    return $this->db->get('users_tbl')->row_array();
}



public function check_customer_phone($email, $phone_no)
{
    $this->db->where('email', $email);
    $this->db->where('phone_no', $phone_no);
    $this->db->where('user_type', 'customer');

    return $this->db->get('users_tbl')->row_array();
}

public function insert_customer($data)
{
    $data['user_type'] = 'customer'; // Ensure user_type is set to 'customer'
    $this->db->insert('users_tbl', $data);
    return $this->db->insert_id(); // Return the ID of the inserted customer
}

//insert requests
public function insert_request($data)
{
    $this->db->insert('req_form_tbl', $data);
    return $this->db->insert_id(); // Return the ID of the inserted request
}

//list

public function get_customer_by_id($customer_id)
{
    $this->db->where('id', $customer_id);
    $this->db->where('user_type', 'customer');
    $this->db->where('is_active', 1);
    return $this->db->get('users_tbl')->row_array();    

}
}