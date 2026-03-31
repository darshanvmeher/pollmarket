<?php
Defined ('BASEPATH') OR exit('No direct script access allowed');

class Address_model extends CI_Model {

public function insert_address($data)
{
    return $this->db->insert('address_book_tbl', $data);
    
}
public function get_addresses($user_id = null)
{
    $this->db->where('delete_status',0);
    if ($user_id !== null) {
        $this->db->where('user_id', $user_id);
    }
    return $this->db->get('address_book_tbl')->result_array();
}

public function update_address($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('address_book_tbl', $data);

}

public function soft_delete_address($id)
{
    $this->db->where('id', $id);
    return $this->db->update('address_book_tbl', ['delete_status' => 1]);
}

public function get_address_by_id($id)
{
    $this->db->where('id', $id)
             ->where('delete_status', 0);
    return $this->db->get('address_book_tbl')->row_array();
}

}