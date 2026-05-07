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

/*public function get_orders_for_admin()
{
    $this->db->select('concat(u.firstname, " ", u.lastname) as customer_name,o.id as order_id,o.order_status as Status,o.created_at as Date,o.total_amount as Amount, p.product_name as Product,oi.quantity as Items'); // Select order and address fields, and customer name
    $this->db->from('order_tbl o');
    //$this->db->join('address_book_tbl a', 'o.address_id = a.id', 'left');
    $this->db->join('order_items_tbl oi', 'o.id = oi.order_id', 'left');
    $this->db->join('product_tbl p', 'oi.product_id = p.id', 'left');
    $this->db->join('users_tbl u', 'o.user_id = u.id', 'left');
    $this->db->where('o.delete_status', 0);
    return $this->db->get()->result_array();
}*/

/*
public function get_orders_for_admin()
{
    $this->db->select('
        o.id as order_id,
        CONCAT(u.firstname, " ", u.lastname) as customer_name,
        o.total_amount as Amount,
        SUM(oi.quantity) as Items,
        o.order_status as Status,
        o.created_at as Date
    ');

    $this->db->from('order_tbl o');
    $this->db->join('order_items_tbl oi', 'o.id = oi.order_id', 'left');
    $this->db->join('users_tbl u', 'o.user_id = u.id', 'left');

    $this->db->group_by('o.id'); // 🔥 IMPORTANT

    return $this->db->get()->result_array();
}*/

/*
public function get_orders_for_admin()
{
    $this->db->select('
        o.id as Order,
        CONCAT(u.firstname, " ", u.lastname) as Customer,
        o.total_amount as Amount,
        GROUP_CONCAT(p.product_name SEPARATOR ", ") as Products,
        (oi.quantity) as Items,
        o.order_status as Status,
        o.created_at as Date
    ');

    $this->db->from('order_tbl o');
    $this->db->join('order_items_tbl oi', 'o.id = oi.order_id', 'left');
    $this->db->join('product_tbl p', 'oi.product_id = p.id', 'left');
    $this->db->join('users_tbl u', 'o.user_id = u.id', 'left');

    $this->db->group_by('o.id');

    return $this->db->get()->result_array();
}
    */


public function get_orders_for_admin()
{
    $this->db->select('
        o.id as Order,
        CONCAT(u.firstname, " ", u.lastname) as Customer,
        o.total_amount as Amount,
        GROUP_CONCAT(p.product_name SEPARATOR ", ") as Products,
        SUM(oi.quantity) as Items,
        o.order_status as Status,
        o.created_at as Date
    ');

    $this->db->from('order_tbl o');
    $this->db->join('order_items_tbl oi', 'o.id = oi.order_id', 'left');
    $this->db->join('product_tbl p', 'oi.product_id = p.id', 'left');
    $this->db->join('users_tbl u', 'o.user_id = u.id', 'left');
    $this->db->group_by('o.id');

    return $this->db->get()->result_array();
}

public function get_orders_for_customer($user_id)
{
    $select = array(
        'o.*',
        'COUNT(DISTINCT oi.id) as line_items_count',
        'COALESCE(SUM(oi.quantity), 0) as total_quantity',
        'GROUP_CONCAT(DISTINCT p.product_name ORDER BY p.product_name SEPARATOR ", ") as product_names'
    );

    $has_payment_table = $this->db->table_exists('payment_tbl');
    $has_address_id = $this->db->field_exists('address_id', 'order_tbl');

    if ($has_payment_table) {
        $select[] = 'pay.payment_method';
        $select[] = 'pay.payment_status';
        $select[] = 'pay.transaction_id';
    }

    if ($has_address_id) {
        $select[] = 'a.address';
        $select[] = 'a.city';
        $select[] = 'a.state';
        $select[] = 'a.pincode';
        $select[] = 'a.country';
    }

    $this->db->select(implode(',', $select));
    $this->db->from('order_tbl o');
    $this->db->join('order_items_tbl oi', 'oi.order_id = o.id AND oi.delete_status = 0', 'left');
    $this->db->join('product_tbl p', 'p.id = oi.product_id', 'left');

    if ($has_payment_table) {
        $this->db->join('payment_tbl pay', 'pay.order_id = o.id', 'left');
    }

    if ($has_address_id) {
        $this->db->join('address_book_tbl a', 'a.id = o.address_id', 'left');
    }

    $this->db->where('o.user_id', $user_id);
    $this->db->where('o.delete_status', 0);
    $this->db->group_by('o.id');
    $this->db->order_by('o.id', 'DESC');

    return $this->db->get()->result_array();
}

public function get_order_items_for_customer($order_id)
{
    $this->db->select('
        oi.id,
        oi.order_id,
        oi.product_id,
        oi.quantity,
        oi.price,
        p.product_name,
        p.description,
        p.badge,
        p.rating,
        MIN(pm.media_path) as image_url
    ');
    $this->db->from('order_items_tbl oi');
    $this->db->join('product_tbl p', 'p.id = oi.product_id', 'left');
    $this->db->join('product_media_tbl pm', 'pm.product_id = p.id AND pm.delete_status = 0', 'left');
    $this->db->where('oi.order_id', $order_id);
    $this->db->where('oi.delete_status', 0);
    $this->db->group_by('oi.id');

    return $this->db->get()->result_array();
}

public function get_order_detail_for_admin($order_id)
{
    $select = array(
        'o.*',
        'CONCAT(COALESCE(u.firstname, ""), " ", COALESCE(u.lastname, "")) as customer_name',
        'u.firstname',
        'u.lastname',
        'u.email as customer_email',
        'u.phone_no as customer_phone'
    );

    $has_address_id = $this->db->field_exists('address_id', 'order_tbl');
    $has_payment_table = $this->db->table_exists('payment_tbl');

    if ($has_address_id) {
        $select[] = 'a.address';
        $select[] = 'a.city';
        $select[] = 'a.state';
        $select[] = 'a.pincode';
        $select[] = 'a.country';
    }

    if ($has_payment_table) {
        $select[] = 'p.payment_method';
        $select[] = 'p.payment_status';
        $select[] = 'p.transaction_id';
    }

    $this->db->select(implode(',', $select));
    $this->db->from('order_tbl o');
    $this->db->join('users_tbl u', 'u.id = o.user_id', 'left');

    if ($has_address_id) {
        $this->db->join('address_book_tbl a', 'a.id = o.address_id', 'left');
    }

    if ($has_payment_table) {
        $this->db->join('payment_tbl p', 'p.order_id = o.id', 'left');
    }

    $this->db->where('o.id', $order_id);
    $this->db->where('o.delete_status', 0);

    return $this->db->get()->row_array();
}

public function get_order_items_for_admin($order_id)
{
    $this->db->select('
        oi.id,
        oi.order_id,
        oi.product_id,
        oi.quantity,
        oi.price,
        pr.product_name,
        pr.badge,
        pr.rating,
        MIN(pm.media_path) as image_url
    ');
    $this->db->from('order_items_tbl oi');
    $this->db->join('product_tbl pr', 'pr.id = oi.product_id', 'left');
    $this->db->join('product_media_tbl pm', 'pm.product_id = pr.id AND pm.delete_status = 0', 'left');
    $this->db->where('oi.order_id', $order_id);
    $this->db->where('oi.delete_status', 0);
    $this->db->group_by('oi.id');

    return $this->db->get()->result_array();
}

//invoice 

//insert

public function insert_invoice($order_id)
{
    // ✅ Get Order
    $order = $this->db
        ->where('id', $order_id)
        ->get('order_tbl')
        ->row();

    if (!$order) {

        return array(

            'status' => false,

            'message' => 'Order not found'
        );
    }

    // ✅ Check Existing Invoice
    $already_exists = $this->db
        ->where('fk_order_id', $order_id)
        ->get('invoice_tbl')
        ->num_rows();

    if ($already_exists > 0) {

        return array(

            'status' => false,

            'message' => 'Invoice already generated'
        );
    }

    // ✅ Get Customer
    $customer = $this->db
        ->where('id', $order->user_id)
        ->get('users_tbl')
        ->row();

    // ✅ Get Order Items + Product Details
    $items = $this->db
        ->select('
            order_items_tbl.*,
            product_tbl.product_name,
            product_tbl.sku,
            product_tbl.price as product_price
        ')
        ->from('order_items_tbl')
        ->join(
            'product_tbl',
            'product_tbl.id = order_items_tbl.product_id',
            'left'
        )
        ->where('order_items_tbl.order_id', $order_id)
        ->get()
        ->result();

    if (empty($items)) {

        return array(

            'status' => false,

            'message' => 'No order items found'
        );
    }

    // ✅ Generate Invoice Number
    $invoice_no = 'PM-INV-' . str_pad(
        $order->id,
        4,
        '0',
        STR_PAD_LEFT
    );

    // ✅ Insert Invoice Items
    foreach ($items as $item) {

        $qty = $item->quantity ?? 0;

        $rate = $item->product_price ?? 0;

        $amount = $rate * $qty;

        $insert_data = array(

            'fk_user_id' => $order->user_id,

            'fk_product_id' => $item->product_id,

            'fk_order_id' => $order->id,

            'fk_address_id' => $order->address_id,

            'invoice_no' => $invoice_no,

           // 'gstin' => $customer->gstin ?? '',
          
           'gstin' => '27AAECS1234F1Z5',

            'sku' => $item->sku ?? '',

            'product_name' => $item->product_name ?? '',

            'quantity' => $qty,

            'rate' => $rate,

            'amount' => $amount,

            'sub_total' => $order->subtotal ?? 0,

            'discount' => $order->discount_value ?? 0,

            'tax' => $order->gst ?? 0,

            'shipping' => $order->shipping ?? 0,

            'grand_total' => $order->total_amount ?? 0,

            'status' => $order->order_status ?? '',

            'invoice_date' => date('Y-m-d'),

            'due_date' => date(
                'Y-m-d',
                strtotime('+7 days')
            )
        );

        $this->db->insert(
            'invoice_tbl',
            $insert_data
        );
    }

    // ✅ Success Response
    return array(

        'status' => true,

        'message' => 'Invoice generated successfully',

        'invoice_no' => $invoice_no
    );
}
}
