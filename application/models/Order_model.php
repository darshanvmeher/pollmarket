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

//Report by data range & status today
/*
public function get_sales_report_by_today($today, $status){
    $this->db->select('*');
    $this->db->from('order_tbl');
    $this->db->where('DATE(created_at)', $today);
    if($status != 'all'){
        $this->db->where('order_status', $status);
    }elseif($status == 'pending'){
        $this->db->where('order_status', $status);
    }elseif($status == 'delievered'){
        $this->db->where('order_status', $status);
}else{
    $this->db->where('order_status', $status);
}

    return $this->db->get()->result_array();
}
*/
/*
public function get_sales_report_by_today($today, $status = 'all')
{
    $this->db->select('*');
    $this->db->from('order_tbl');

    $this->db->where('DATE(created_at)', $today);

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    return $this->db->get()->result_array();
}
    */


/*
public function get_by_kpis()
{
    $this->db->select('
        o.created_at as date,
    SUM(o.total_amount) as gross,
        SUM(o.subtotal) as net,
        COUNT(o.id) as orders,
        SUM(oi.quantity) as items,
        SUM(o.discount_value) as discount,
       AVG(o.total_amount) as avg_order_value
    ');
    $this->db->from('order_tbl as o');
    $this->db->join('order_items_tbl as oi', 'oi.order_id = o.id', 'left');
    $this->db->where('date(o.created_at)', date('Y-m-d'));
    //return $this->db->get()->row_array();
    return $this->db->get()->result_array();

}*/

// corrected code for report by date range & status today
/*public function get_by_kpis($today, $status = 'all')
{
    $status = trim($status);

    // Orders KPI
    $this->db->select('
        COUNT(id) as orders,
        SUM(subtotal) as gross,
        SUM(total_amount) as net,
        SUM(discount_value) as discount
    ');

    $this->db->from('order_tbl');

    $this->db->where('DATE(created_at)', $today);

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $order_data = $this->db->get()->row_array();


    // Items KPI
    $this->db->select('SUM(oi.quantity) as items');

    $this->db->from('order_items_tbl oi');

    $this->db->join('order_tbl o', 'o.id = oi.order_id', 'left');

    $this->db->where('DATE(o.created_at)', $today);

    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $item_data = $this->db->get()->row_array();


    return [

        'date' => $today,

        'orders' => $order_data['orders'] ?? 0,

        'gross' => $order_data['gross'] ?? 0,

        'net' => $order_data['net'] ?? 0,

        'discount' => $order_data['discount'] ?? 0,

        'items' => $item_data['items'] ?? 0,

        'channel' => 'Website'
    ];
}

*/


//correctt code for report by date range & status last 7 days kpis

public function get_by_kpis($start_date,$end_date,$status = 'all')
{
    $status = trim($status);

    // Orders KPI
    $this->db->select('
        COUNT(DISTINCT id) as orders,
        SUM(subtotal) as gross,
        SUM(total_amount) as net,
        SUM(discount_value) as discount
    ');

    $this->db->from('order_tbl');

    if (!empty($start_date)) {
        $this->db->where('DATE(created_at) >=', $start_date);
    }

    if (!empty($end_date)) {
        $this->db->where('DATE(created_at) <=', $end_date);
    }

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $order_data = $this->db->get()->row_array();

    // Items KPI
    $this->db->select('SUM(oi.quantity) as items');

    $this->db->from('order_items_tbl oi');

    $this->db->join('order_tbl o', 'o.id = oi.order_id', 'left');

    if (!empty($start_date)) {
        $this->db->where('DATE(o.created_at) >=', $start_date);
    }

    if (!empty($end_date)) {
        $this->db->where('DATE(o.created_at) <=', $end_date);
    }

    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $item_data = $this->db->get()->row_array();

    return [
        'date' => $start_date . ' to ' . $end_date,
        'orders' => $order_data['orders'] ?? 0,
        'gross' => $order_data['gross'] ?? 0,
        'net' => $order_data['net'] ?? 0,
        'discount' => $order_data['discount'] ?? 0,
        'items' => $item_data['items'] ?? 0,
        'channel' => 'Website'
    ];
}

/*public function get_by_kpis($start_date,$end_date,$status = 'all')
{
    $status = trim($status);

    // Orders KPI
    $this->db->select('
        COUNT(id) as orders,
        SUM(subtotal) as gross,
        SUM(total_amount) as net,
        SUM(discount_value) as discount
    ');

    $this->db->from('order_tbl');

   // $this->db->where('DATE(created_at)', $day_ago);
   // $this->db->where('DATE(created_at) >=', $start_date);
    //$this->db->where('DATE(created_at) <=', $end_date);

if (!empty($start_date)) {
    $this->db->where('DATE(created_at) >=', $start_date);
}

if (!empty($end_date)) {
    $this->db->where('DATE(created_at) <=', $end_date);
}
    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $order_data = $this->db->get()->row_array();

    // Items KPI
    $this->db->select('SUM(oi.quantity) as items');
    $this->db->from('order_items_tbl oi');
    $this->db->join('order_tbl o', 'o.id = oi.order_id', 'left');                 
    $this->db->where('DATE(o.created_at) >=', $start_date);
    $this->db->where('DATE(o.created_at) <=', $end_date);
    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }
    $item_data = $this->db->get()->row_array();

    return [
        'date' => $start_date . ' to ' . $end_date,
        'orders' => $order_data['orders'] ?? 0,
        'gross' => $order_data['gross'] ?? 0,
        'net' => $order_data['net'] ?? 0,
        'discount' => $order_data['discount'] ?? 0,
        'items' => $item_data['items'] ?? 0,
        'channel' => 'Website'
    ];
}*/

/*

public function get_by_kpis($today, $status = 'all')
{
    $status = trim($status);

    // Orders KPI
    $this->db->select('
        COUNT(id) as orders,
        SUM(subtotal) as gross,
        SUM(total_amount) as net,
        SUM(discount_value) as discount
    ');

    $this->db->from('order_tbl');

    $this->db->where('DATE(created_at)', $today);

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $order_data = $this->db->get()->row_array();


    // Items KPI
    $this->db->select('SUM(oi.quantity) as items');

    $this->db->from('order_items_tbl oi');

    $this->db->join('order_tbl o', 'o.id = oi.order_id', 'left');

    $this->db->where('DATE(o.created_at)', $today);

    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $item_data = $this->db->get()->row_array();


    return [

        'date' => $today,

        'orders' => $order_data['orders'] ?? 0,

        'gross' => $order_data['gross'] ?? 0,

        'net' => $order_data['net'] ?? 0,

        'discount' => $order_data['discount'] ?? 0,

        'items' => $item_data['items'] ?? 0,

        'channel' => 'Website'
    ];
}public function get_by_kpis($today, $status = 'all')
{
    $status = trim($status);

    // Orders KPI
    $this->db->select('
        COUNT(id) as orders,
        SUM(subtotal) as gross,
        SUM(total_amount) as net,
        SUM(discount_value) as discount
    ');

    $this->db->from('order_tbl');

    $this->db->where('DATE(created_at)', $today);

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $order_data = $this->db->get()->row_array();


    // Items KPI
    $this->db->select('SUM(oi.quantity) as items');

    $this->db->from('order_items_tbl oi');

    $this->db->join('order_tbl o', 'o.id = oi.order_id', 'left');

    $this->db->where('DATE(o.created_at)', $today);

    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $item_data = $this->db->get()->row_array();


    return [

        'date' => $today,

        'orders' => $order_data['orders'] ?? 0,

        'gross' => $order_data['gross'] ?? 0,

        'net' => $order_data['net'] ?? 0,

        'discount' => $order_data['discount'] ?? 0,

        'items' => $item_data['items'] ?? 0,

        'channel' => 'Website'
    ];
}
/*
public function get_by_kpis($today, $status = 'all')
{
    $status = trim($status);

    // Orders KPI
    $this->db->select('
        COUNT(id) as orders,
        SUM(subtotal) as gross,
        SUM(total_amount) as net,
        SUM(discount_value) as discount
    ');

    $this->db->from('order_tbl');

    $this->db->where('DATE(created_at)', $today);

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $order_data = $this->db->get()->row_array();


    // Items KPI
    $this->db->select('SUM(oi.quantity) as items');

    $this->db->from('order_items_tbl oi');

    $this->db->join('order_tbl o', 'o.id = oi.order_id', 'left');

    $this->db->where('DATE(o.created_at)', $today);

    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $item_data = $this->db->get()->row_array();


    return [

        'date' => $today,

        'orders' => $order_data['orders'] ?? 0,

        'gross' => $order_data['gross'] ?? 0,

        'net' => $order_data['net'] ?? 0,

        'discount' => $order_data['discount'] ?? 0,

        'items' => $item_data['items'] ?? 0,

        'channel' => 'Website'
    ];
}
/*
public function get_by_kpis($today, $status = 'all')
{

    $status = trim($status);

   $this->db->select('
    COUNT(id) as orders,
    SUM(subtotal) as gross,
    SUM(total_amount) as net,
    SUM(discount_value) as discount
');

    $this->db->from('order_tbl');

    $this->db->where('DATE(created_at)', $today);

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $order_data = $this->db->get()->row_array();

    $this->db->select('SUM(quantity) as items');

    $this->db->from('order_items_tbl');

    $this->db->where('DATE(created_at)', $today);

    $item_data = $this->db->get()->row_array();

    return [

        'date' => $today,

        'orders' => $order_data['orders'] ?? 0,

        'gross' => $order_data['gross'] ?? 0,

        'net' => $order_data['net'] ?? 0,

        'discount' => $order_data['discount'] ?? 0,

        'items' => $item_data['items'] ?? 0,

        'channel' => 'Website'
    ];
}
/*
/*
public function get_sales_report_by_today($today, $status = 'all')
{
    $this->db->select("
        DATE(created_at) as date,
        COUNT(id) as orders,
        SUM(quantity) as items,
        SUM(total_amount) as gross,
        SUM(discount_amount) as discount,
        (SUM(total_amount) - SUM(discount_amount)) as net,
        'Website' as channel
    ");

    $this->db->from('order_tbl');

    $this->db->where('DATE(created_at)', $today);

    if ($status != 'all') {
        $this->db->where('order_status', $status);
    }

    $this->db->group_by('DATE(created_at)');

    return $this->db->get()->result_array();
}
*/

//corrected code for report by date range & status today
/*public function get_sales_report_by_today($today, $status = 'all')
{
    $status = trim($status);

    $this->db->select("
        DATE(o.created_at) as date,
        COUNT(DISTINCT o.id) as orders,
        SUM(oi.quantity) as items,
        SUM(o.subtotal) as gross,
        SUM(o.discount_value) as discount,
        SUM(o.total_amount) as net
    ");

    $this->db->from('order_tbl o');

    $this->db->join('order_items_tbl oi', 'oi.order_id = o.id', 'left');

    $this->db->where('DATE(o.created_at)', $today);

    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $this->db->group_by('DATE(o.created_at)');

    $query = $this->db->get();

    $result = $query->result_array();

    foreach ($result as &$row) {
        $row['channel'] = ucfirst($status == 'all' ? 'Website' : $status);
    }

    return $result;
}
*/

//correctt code for report by date range & status last 7 days
/*
public function get_sales_report_by_custom_date_range($start_date, $end_date,$status = 'all')
{
    $status = trim($status);

    $this->db->select("
        DATE(o.created_at) as date,
        COUNT(DISTINCT o.id) as orders,
        SUM(oi.quantity) as items,
        SUM(DISTINCT o.subtotal) as gross,
        SUM(DISTINCT o.discount_value) as discount,
        SUM(DISTINCT o.total_amount) as net
    ");

    $this->db->from('order_tbl o');

    $this->db->join('order_items_tbl oi', 'oi.order_id = o.id', 'left');

    // Date filter
    //$this->db->where('DATE(o.created_at) >=', $start_date);
    //$this->db->where('DATE(o.created_at) <=', $end_date);

    if (!empty($start_date)) {
    $this->db->where('DATE(o.created_at) >=', $start_date);
    }

    if (!empty($end_date)) {
    $this->db->where('DATE(o.created_at) <=', $end_date);
    }

    // Status filter
    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $this->db->group_by('DATE(o.created_at)');

    $query = $this->db->get();

    $result = $query->result_array();

    foreach ($result as &$row) {
        $row['channel'] = ucfirst($status == 'all' ? 'Website' : $status);
    }

    return $result;
}

/*
public function get_sales_report_by_custom_date_range($start_date, $end_date, $status = 'all')
{
    $status = trim($status);

    $this->db->select("
        DATE(o.created_at) as date,
        COUNT(DISTINCT o.id) as orders,
        SUM(oi.quantity) as items,
        SUM(o.subtotal) as gross,
        SUM(o.discount_value) as discount,
        SUM(o.total_amount) as net
    ");

    $this->db->from('order_tbl o');

    $this->db->join('order_items_tbl oi', 'oi.order_id = o.id', 'left');

   // $this->db->where('DATE(o.created_at)', $days_ago);
   // $this->db->where('DATE(o.created_at) >=', $start_date);
    //$this->db->where('DATE(o.created_at) <=', $end_date);
  //  $this->db->where('DATE(o.created_at) >=', $start_date);
   // $this->db->where('DATE(o.created_at) <=', $end_date);

    $this->db->where('DATE(o.created_at) >=', $start_date);
    $this->db->where('DATE(o.created_at) <=', $end_date);

    if ($status != 'all') {
        $this->db->where('o.order_status', $status);
    }

    $this->db->group_by('DATE(o.created_at)');

    $query = $this->db->get();

    $result = $query->result_array();

    foreach ($result as &$row) {
        $row['channel'] = ucfirst($status == 'all' ? 'Website' : $status);
    }

    return $result;
}


public function get_sales_report($start_date, $end_date, $status = 'all')
{
    $status = trim($status);

    $this->db->select("
        DATE(o.created_at) as date,

        COUNT(DISTINCT o.id) as orders,

        SUM(oi.quantity) as items,

        SUM(o.subtotal) as gross,

        SUM(o.discount_value) as discount,

        SUM(o.total_amount) as net
    ");

    $this->db->from('order_tbl o');

    $this->db->join(
        'order_items_tbl oi',
        'oi.order_id = o.id',
        'left'
    );

    // Date filter
    if (!empty($start_date)) {

        $this->db->where(
            'DATE(o.created_at) >=',
            $start_date
        );
    }

    if (!empty($end_date)) {

        $this->db->where(
            'DATE(o.created_at) <=',
            $end_date
        );
    }

    // Status filter
    if ($status != 'all') {

        $this->db->where(
            'o.order_status',
            $status
        );
    }

    /*
    IMPORTANT FIX
    Group by ORDER ID first
    to prevent duplicate totals
    */
/*
    $this->db->group_by('o.id');

    $query = $this->db->get();

    $result = $query->result_array();

    // Final date-wise merge
    $final = [];

    foreach ($result as $row) {

        $date = $row['date'];

        if (!isset($final[$date])) {

            $final[$date] = [

                'date' => $date,

                'orders' => 0,

                'items' => 0,

                'gross' => 0,

                'discount' => 0,

                'net' => 0,

                'channel' => 'Website'
            ];
        }

        $final[$date]['orders'] += $row['orders'];

        $final[$date]['items'] += $row['items'];

        $final[$date]['gross'] += $row['gross'];

        $final[$date]['discount'] += $row['discount'];

        $final[$date]['net'] += $row['net'];
    }

    return array_values($final);
*/



public function get_sales_report($start_date, $end_date, $status = 'all')
{
    $status = trim($status);

    // =====================================
    // MAIN SALES REPORT QUERY
    // =====================================

    $this->db->select("
        DATE(o.created_at) as date,

        COUNT(DISTINCT o.id) as orders,

        SUM(o.subtotal) as gross,

        SUM(o.discount_value) as discount,

        SUM(o.total_amount) as net
    ");

    $this->db->from('order_tbl o');

    // Date Filters
    if (!empty($start_date)) {

        $this->db->where(
            'DATE(o.created_at) >=',
            $start_date
        );
    }

    if (!empty($end_date)) {

        $this->db->where(
            'DATE(o.created_at) <=',
            $end_date
        );
    }

    // Status Filter
    if ($status != 'all') {

        $this->db->where(
            'o.order_status',
            $status
        );
    }

    // Group by Date
    $this->db->group_by('DATE(o.created_at)');

    // Latest First
    $this->db->order_by('DATE(o.created_at)', 'DESC');

    $query = $this->db->get();

    $result = $query->result_array();

    // =====================================
    // GET ITEMS COUNT SEPARATELY
    // =====================================

    foreach ($result as &$row) {

        $this->db->select('SUM(oi.quantity) as items');

        $this->db->from('order_items_tbl oi');

        $this->db->join(
            'order_tbl o',
            'o.id = oi.order_id',
            'left'
        );

        $this->db->where(
            'DATE(o.created_at)',
            $row['date']
        );

        // Status Filter
        if ($status != 'all') {

            $this->db->where(
                'o.order_status',
                $status
            );
        }

        $items_data = $this->db->get()->row_array();

        $row['items'] = $items_data['items'] ?? 0;

        $row['channel'] = 'Website';
    }

    return $result;
}

/*
public function get_sales_report_excel()
{
    $this->db->select("
        DATE(o.created_at) as date,
        COUNT(DISTINCT o.id) as orders,
        SUM(oi.quantity) as items,
        SUM(o.subtotal) as gross_sales,
        SUM(o.discount_value) as discount,
        SUM(o.total_amount) as net_sales
    ");

    $this->db->from('order_tbl o');

    $this->db->join(
        'order_items_tbl oi',
        'oi.order_id = o.id',
        'left'
    );

    $this->db->where('o.delete_status',0);

    $this->db->group_by('DATE(o.created_at)');

    return $this->db->get()->result_array();
}*/
public function get_sales_report_excel($date_range = '', $order_status = '')
{
    $this->db->select("
        DATE(o.created_at) as date,
        COUNT(DISTINCT o.id) as orders,
        SUM(oi.quantity) as items,
        SUM(o.subtotal) as gross_sales,
        SUM(o.discount_value) as discount,
        SUM(o.total_amount) as net_sales
    ");

    $this->db->from('order_tbl o');

    $this->db->join(
        'order_items_tbl oi',
        'oi.order_id = o.id',
        'left'
    );

    $this->db->where('o.delete_status',0);

    // Order status filter
    if (!empty($order_status) && $order_status != 'all') {

        $this->db->where(
            'o.order_status',
            $order_status
        );
    }

    // Today
    if ($date_range == 'today') {

        $start_date = date('Y-m-d');
        $end_date   = date('Y-m-d');

    }

    // Last 7 Days
    else if ($date_range == 'week') {

        $start_date = date(
            'Y-m-d',
            strtotime('-6 days')
        );

        $end_date = date('Y-m-d');

    }

    // This Month
    else if ($date_range == 'month') {

        $start_date = date('Y-m-01');
        $end_date   = date('Y-m-t');

    }

    // Custom Range
    else if ($date_range == 'custom') {

        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');
    }

    // APPLY DATE FILTER
    if (!empty($start_date) && !empty($end_date)) {

        $this->db->where(
            'DATE(o.created_at) >=',
            $start_date
        );

        $this->db->where(
            'DATE(o.created_at) <=',
            $end_date
        );
    }

    $this->db->group_by('DATE(o.created_at)');

    return $this->db->get()->result_array();
}

//gst sales summary
/*
 public function get_gst_sales_summary(
        $date_range = '',
        $start_date = '',
        $end_date = ''
    )
    {

        $this->db->select('
            i.invoice_no,

            CONCAT(
                u.firstname,
                " ",
                u.lastname
            ) as customer_name,

            u.state,

            i.product_name,
            i.quantity,
            i.sub_total,
            i.discount,
            i.tax,
            i.shipping,
            i.grand_total,
            i.invoice_date
        ');

        // invoice_tbl as i
        $this->db->from('invoice_tbl as i');

        // users_tbl as u
        $this->db->join(
            'users_tbl as u',
            'u.id = i.fk_user_id',
            'left'
        );

        $this->db->where(
            'i.delete_status',
            0
        );

        // TODAY
        if ($date_range == 'today') {

            $this->db->where(
                'DATE(i.invoice_date)',
                date('Y-m-d')
            );
        }

        // LAST 7 DAYS
        elseif ($date_range == 'last7days') {

            $this->db->where(
                'DATE(i.invoice_date) >=',
                date('Y-m-d', strtotime('-6 days'))
            );
        }

        // THIS MONTH
        elseif ($date_range == 'thismonth') {

            $this->db->where(
                'MONTH(i.invoice_date)',
                date('m')
            );

            $this->db->where(
                'YEAR(i.invoice_date)',
                date('Y')
            );
        }

        // CUSTOM RANGE
        elseif ($date_range == 'custom') {

            if (
                !empty($start_date)
                && !empty($end_date)
            ) {

                $this->db->where(
                    'DATE(i.invoice_date) >=',
                    $start_date
                );

                $this->db->where(
                    'DATE(i.invoice_date) <=',
                    $end_date
                );
            }
        }

        $this->db->order_by(
            'i.id',
            'ASC'
        );

        return $this->db
            ->get()
            ->result_array();
    }*/


            public function get_gst_sales_summary(
    $date_range = '',
    $start_date = '',
    $end_date = ''
)
{

    $this->db->select('

        i.invoice_no,

        CONCAT(
            u.firstname,
            " ",
            u.lastname
        ) as customer_name,

        u.state,

        SUM(i.sub_total) as sub_total,

        SUM(i.discount) as discount,

        SUM(i.tax) as tax,

        SUM(i.shipping) as shipping,

        SUM(i.grand_total) as grand_total,

        i.invoice_date
    ');

    // invoice table
    $this->db->from('invoice_tbl as i');

    // users table join
    $this->db->join(
        'users_tbl as u',
        'u.id = i.fk_user_id',
        'left'
    );

    // delete status
    $this->db->where(
        'i.delete_status',
        0
    );

    // TODAY
    if ($date_range == 'today') {

        $this->db->where(
            'DATE(i.invoice_date)',
            date('Y-m-d')
        );
    }

    // LAST 7 DAYS
  /*  elseif ($date_range == 'last7days') {

        $this->db->where(
            'DATE(i.invoice_date) >=',
            date(
                'Y-m-d',
                strtotime('-7 days')
            )
        );
    }*/

        elseif ($date_range == 'week') {

    $this->db->where(
        'DATE(i.invoice_date) >=',
        date(
            'Y-m-d',
            strtotime('-6 days')
        )
    );

    $this->db->where(
        'DATE(i.invoice_date) <=',
        date('Y-m-d')
    );
}

    // THIS MONTH
    elseif ($date_range == 'month') {

        $this->db->where(
            'MONTH(i.invoice_date)',
            date('m')
        );

        $this->db->where(
            'YEAR(i.invoice_date)',
            date('Y')
        );
    }

    // CUSTOM RANGE
    elseif ($date_range == 'custom') {

        if (
            !empty($start_date)
            && !empty($end_date)
        ) {

            $this->db->where(
                'DATE(i.invoice_date) >=',
                $start_date
            );

            $this->db->where(
                'DATE(i.invoice_date) <=',
                $end_date
            );
        }
    }

    // group by invoice
    $this->db->group_by(
        'i.invoice_no'
    );

    // latest first
    $this->db->order_by(
        'i.id',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}

//statewise gst report
/*
public function get_statewise_gst_report(
    $date_range = '',
    $start_date = '',
    $end_date = ''
)
{

    $this->db->select('

        a.state,

        SUM(i.sub_total) as taxable_value,

        SUM(i.tax) as gst_collected,

        COUNT(DISTINCT i.invoice_no) as invoices

    ');

    // INVOICE TABLE
    $this->db->from(
        'invoice_tbl as i'
    );

    // ADDRESS TABLE JOIN
    $this->db->join(
        'address_book_tbl as a',
        'a.id = i.fk_address_id',
        'left'
    );

    // DELETE STATUS
    $this->db->where(
        'i.delete_status',
        0
    );

    // TODAY
    if ($date_range == 'today') {

        $this->db->where(
            'DATE(i.invoice_date)',
            date('Y-m-d')
        );
    }

    // LAST 7 DAYS
    elseif ($date_range == 'week') {

        $this->db->where(
            'DATE(i.invoice_date) >=',
            date(
                'Y-m-d',
                strtotime('-6 days')
            )
        );

        $this->db->where(
            'DATE(i.invoice_date) <=',
            date('Y-m-d')
        );
    }

    // THIS MONTH
    elseif ($date_range == 'month') {

        $this->db->where(
            'MONTH(i.invoice_date)',
            date('m')
        );

        $this->db->where(
            'YEAR(i.invoice_date)',
            date('Y')
        );
    }

    // CUSTOM DATE
    elseif ($date_range == 'custom') {

        if (
            !empty($start_date)
            && !empty($end_date)
        ) {

            $this->db->where(
                'DATE(i.invoice_date) >=',
                $start_date
            );

            $this->db->where(
                'DATE(i.invoice_date) <=',
                $end_date
            );
        }
    }

    // GROUP BY STATE
    $this->db->group_by(
        'a.state'
    );

    // ORDER BY GST
    $this->db->order_by(
        'gst_collected',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}/*
}
/*
public function get_statewise_gst_report(
    $date_range = '',
    $start_date = '',
    $end_date = ''
)
{

    $this->db->select('

        a.state,

        SUM(i.tax) as total_gst

    ');

    // invoice table
    $this->db->from('invoice_tbl as i');

    // address book table join
    $this->db->join(
        'address_book_tbl as a',
        'a.id = i.fk_address_id',
        'left'
    );

    // delete status
    $this->db->where(
        'i.delete_status',
        0
    );

    // Date range filters (similar to previous function)
    if ($date_range == 'today') {
        $this->db->where(
            'DATE(i.invoice_date)',
            date('Y-m-d')
        );
    } elseif ($date_range == 'week') {
        $this->db->where(
            'DATE(i.invoice_date) >=',
            date(
                'Y-m-d',
                strtotime('-6 days')
            )
        );
        $this->db->where(
            'DATE(i.invoice_date) <=',
            date('Y-m-d')
        );
    } elseif ($date_range == 'month') {
        $this->db->where(
            'MONTH(i.invoice_date)',
            date('m')
        );
        $this->db->where(
            'YEAR(i.invoice_date)',
            date('Y')
        );
    } elseif ($date_range == 'custom') {
        if (
            !empty($start_date)
            && !empty($end_date)
        ) {
            $this->db->where(
                'DATE(i.invoice_date) >=',
                $start_date
            );
            $this->db->where(
                'DATE(i.invoice_date) <=',
                $end_date
            );
        }
    }

    // group by state
    $this->db->group_by(
        'a.state'
    );

    // order by total gst desc
    $this->db->order_by(
        'total_gst',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}

*/

public function get_statewise_gst_report(
    $date_range = '',
    $start_date = '',
    $end_date = ''
)
{

    $this->db->select('

        a.state,

        SUM(i.sub_total) as sub_total,

        SUM(i.tax) as tax,

        COUNT(DISTINCT i.invoice_no) as invoices

    ');

    // INVOICE TABLE
    $this->db->from(
        'invoice_tbl as i'
    );

    // ADDRESS TABLE JOIN
    $this->db->join(
        'address_book_tbl as a',
        'a.id = i.fk_address_id',
        'left'
    );

    // DELETE STATUS
    $this->db->where(
        'i.delete_status',
        0
    );

    // TODAY
    if ($date_range == 'today') {

        $this->db->where(
            'DATE(i.invoice_date)',
            date('Y-m-d')
        );
    }

    // LAST 7 DAYS
    elseif ($date_range == 'week') {

        $this->db->where(
            'DATE(i.invoice_date) >=',
            date(
                'Y-m-d',
                strtotime('-6 days')
            )
        );

        $this->db->where(
            'DATE(i.invoice_date) <=',
            date('Y-m-d')
        );
    }

    // THIS MONTH
    elseif ($date_range == 'month') {

        $this->db->where(
            'MONTH(i.invoice_date)',
            date('m')
        );

        $this->db->where(
            'YEAR(i.invoice_date)',
            date('Y')
        );
    }

    // CUSTOM RANGE
    elseif ($date_range == 'custom') {

        if (
            !empty($start_date)
            &&
            !empty($end_date)
        ) {

            $this->db->where(
                'DATE(i.invoice_date) >=',
                $start_date
            );

            $this->db->where(
                'DATE(i.invoice_date) <=',
                $end_date
            );
        }
    }

    // GROUP BY STATE
    $this->db->group_by(
        'a.state'
    );

    // ORDER BY TAX DESC
    $this->db->order_by(
        'tax',
        'DESC'
    );

    return $this->db
        ->get()
        ->result_array();
}

}