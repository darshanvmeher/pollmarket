<?php
defined ('BASEPATH') OR exit('No direct script access allowed');

class Attribute_model extends CI_Model {


public function insert_attribute($data)
{
    return $this->db->insert('attributes_tbl', $data);
}

public function get_attributes()
{
    $this->db->where('delete_status',0);
    return $this->db->get('attributes_tbl')->result_array();
}

public function update_attribute($id,$data)
{
    $this->db->where('id',$id);
    return $this->db->update('attributes_tbl',$data);
}

public function soft_delete_attribute($id)
{
    $this->db->where('id',$id);
    return $this->db->update('attributes_tbl',['delete_status' => 1]);
}

public function get_attribute_by_id($id)
{
    $this->db->where('id',$id)
             ->where('delete_status',0);       
    return $this->db->get('attributes_tbl')->row_array();

}

}