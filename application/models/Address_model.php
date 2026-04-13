<?php
Defined ('BASEPATH') OR exit('No direct script access allowed');

class Address_model extends CI_Model {

public function insert_address($data)
{
    $inserted = $this->db->insert('address_book_tbl', $data);
    if (!$inserted) {
        return false;
    }

    return $this->db->insert_id();
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

public function get_user_address_by_id($id, $user_id)
{
    $this->db->where('id', $id)
             ->where('user_id', $user_id)
             ->where('delete_status', 0);
    return $this->db->get('address_book_tbl')->row_array();
}

}
