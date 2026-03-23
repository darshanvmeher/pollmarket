<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function insert_order($data)
    {
        return $this->db->insert('order_tbl', $data);
    }


public function update_order($id,$data)
{
    $this->db->where('id',$id);
    return $this->db->update('order_tbl',$data);
}


public function soft_delete_order($id)
{
    $this->db->where('id',$id);
    return $this->db->update('order_tbl',['delete_status'=>1]);
}


    public function get_order_by_id($id)
    {
        $this->db->where('id',$id)
                 ->where('delete_status',0);

        return $this->db->get('order_tbl')->row_array();
    }


    public function get_order()
    {
    $this->db->where('delete_status',0);
    return $this->db->get('order_tbl')->result_array();
    }
    


    //order itemms

     public function insert_order_items($data)
    {
        return $this->db->insert('order_items_tbl', $data);
    }


    public function update_order_items($id,$data)
{
    $this->db->where('id',$id);
    return $this->db->update('order_items_tbl',$data);
}


public function soft_delete_order_items($id)
{
    $this->db->where('id',$id);
    return $this->db->update('order_items_tbl',['delete_status'=>1]);
}


    public function get_order_items_by_id($id)
    {
        $this->db->where('id',$id)
                 ->where('delete_status',0);

        return $this->db->get('order_items_tbl')->row_array();
    }


    public function get_order_items()
    {
    $this->db->where('delete_status',0);
    return $this->db->get('order_items_tbl')->result_array();
    }
    


    public function get_orders_with_items()
{
    // Get orders
    $orders = $this->db->where('delete_status', 0)
                       ->get('order_tbl')
                       ->result_array();

    foreach ($orders as &$order) {
        $this->db->where('order_id', $order['id']);
        $this->db->where('delete_status', 0);

        $order['items'] = $this->db->get('order_items_tbl')->result_array();
    }

    return $orders;
}

public function update_order_status($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('order_tbl', $data);
}
    }
