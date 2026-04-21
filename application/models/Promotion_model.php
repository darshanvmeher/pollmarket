<?php
defined ('BASEPATH') OR exit('No direct script access allowed');

class Promotion_model extends CI_Model {


public function insert_promotion($data)
{
    return $this->db->insert('promotions_tbl', $data);
}

public function get_promotions()
{
    $this->db->where('delete_status',0);
    return $this->db->get('promotions_tbl')->result_array();


}

public function update_promotion($id,$data)
{
    $this->db->where('id',$id);
    return $this->db->update('promotions_tbl',$data);
}

public function soft_delete_promotion($id)
{
    $this->db->where('id',$id);
    return $this->db->update('promotions_tbl',['delete_status' => 1]);
}

public function get_promotion_by_id($id)
{
    $this->db->where('id',$id)
             ->where('delete_status',0);       
    return $this->db->get('promotions_tbl')->row_array();


}
/*
public function get_coupon_by_code($code)
{
    $this->db->where('coupon_code', $code);
    $this->db->where('delete_status', 0);
    $this->db->where('status','Active');
    return $this->db->get('promotions_tbl')->row_array();
}*/

public function get_coupon_by_code($code)
{
    return $this->db
        ->where('coupon_code', $code)
        ->where('delete_status', 0)
        ->get('promotions_tbl')
        ->row_array();
}
}