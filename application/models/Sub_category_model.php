<?php
defined ('BASEPATH') OR exit('No direct script access allowed');


class Sub_category_model extends CI_Model {

    public function insert_sub_category($data)
    {
        return $this->db->insert('sub_category_tbl', $data);
    }

    public function get_sub_categories()
    {
        $this->db->select('sub_category_tbl.*, category_tbl.category_name');
        $this->db->from('sub_category_tbl');
        $this->db->join('category_tbl','category_tbl.id = sub_category_tbl.category_id');
        $this->db->where('sub_category_tbl.delete_status',0);

        return $this->db->get()->result_array();
    }

    public function update_sub_category($id,$data)
    {
        $this->db->where('id',$id);
        return $this->db->update('sub_category_tbl',$data);
    }


    public function soft_delete_sub_category($id)
    {
        $this->db->where('id',$id);
        return $this->db->update('sub_category_tbl',['delete_status' => 1]);
    }

    public function get_sub_category_by_id($id)
    {
        $this->db->where('id',$id)
                 ->where('delete_status',0);

        return $this->db->get('sub_category_tbl')->row_array();
    }

    public function get_all_subcategories()
{
    $this->db->select('sc.*, c.category_name');
    $this->db->from('sub_category_tbl sc');
    $this->db->join('category_tbl c', 'c.id = sc.category_id');
    $this->db->where('sc.delete_status', 0);
    return $this->db->get()->result_array();
}
}