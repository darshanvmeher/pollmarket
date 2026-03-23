<?php
defined ('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {


public function insert_category($data)
{
    return $this->db->insert('category_tbl', $data);
}

public function get_categories()
{
    $this->db->where('delete_status',0);
    return $this->db->get('category_tbl')->result_array();
}

public function update_category($id,$data)
{
    $this->db->where('id',$id);
    return $this->db->update('category_tbl',$data);
}

public function soft_delete_category($id)
{
    $this->db->where('id',$id);
    return $this->db->update('category_tbl',['delete_status' => 1]);
}

public function get_category_by_id($id)
{
    $this->db->where('id',$id)
             ->where('delete_status',0);       
    return $this->db->get('category_tbl')->row_array();

}

}