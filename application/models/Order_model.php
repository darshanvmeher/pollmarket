<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

  public function insert_order($data)
{
    $this->db->insert('order_tbl', $data);
    return $this->db->insert_id(); // ✅ IMPORTANT
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


//insert paymement details

public function insert_payment_details($payment_data)
{
    return $this->db->insert('payment_tbl', $payment_data);
}

//add order tbl with join with address tbl

public function get_orders_with_address()
{
    $this->db->select('o.*, a.*');
    $this->db->from('order_tbl o');
    $this->db->join('address_book_tbl a', 'o.address_id = a.id', 'left');
    $this->db->where('o.delete_status', 0);
    return $this->db->get()->result_array();
}
}
