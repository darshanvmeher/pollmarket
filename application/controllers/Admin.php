<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    private $nav = array(
        'dashboard' => array('label' => 'Dashboard', 'icon' => 'bi bi-grid', 'url' => 'admin'),
        'products' => array('label' => 'Products', 'icon' => 'bi bi-bag', 'url' => 'admin/products'),
        'categories' => array('label' => 'Categories', 'icon' => 'bi bi-tags', 'url' => 'admin/categories'),
        'subcategories' => array('label' => 'Subcategories', 'icon' => 'bi bi-diagram-3', 'url' => 'admin/subcategories'),
        'orders' => array('label' => 'Orders', 'icon' => 'bi bi-receipt', 'url' => 'admin/orders'),
      //  'invoice' => array('label' => 'Invoice', 'icon' => 'bi bi-file-earmark-text', 'url' => 'admin/invoice'),
        'customers' => array('label' => 'Customers', 'icon' => 'bi bi-people', 'url' => 'admin/customers'),
        'inventory' => array('label' => 'Inventory', 'icon' => 'bi bi-boxes', 'url' => 'admin/inventory'),
        'suppliers' => array('label' => 'Suppliers', 'icon' => 'bi bi-truck', 'url' => 'admin/suppliers'),
        'promotions' => array('label' => 'Promotions', 'icon' => 'bi bi-megaphone', 'url' => 'admin/promotions'),
        'reports' => array(
            'label' => 'Reports',
            'icon' => 'bi bi-bar-chart',
            'url' => 'admin/reports',
            'children' => array(
                'reports_sales' => array(
                    'label' => 'Sales Report',
                    'url' => 'admin/reports'
                ),
                'reports_gst' => array(
                    'label' => 'GST Sales Summary',
                    'url' => 'admin/reports/gst-sales-summary'
                ),
                'reports_statewise' => array(
                    'label' => 'Statewise GST',
                    'url' => 'admin/reports/statewise-gst'
                )
            )
        ),
        'settings' => array('label' => 'Settings', 'icon' => 'bi bi-gear', 'url' => 'admin/settings')
    );

    public function index()
    {
        $data = array(
            'active' => 'dashboard',
            'title' => 'Dashboard',
            'subtitle' => 'Overview for garbage bags, stationery, silver foil, RFID seals and packaging supplies.',
            'kpis' => array(
                array('title' => 'Revenue (MTD)', 'value' => '$48,920', 'trend' => '+12.8%', 'trend_class' => 'kpi-up'),
                array('title' => 'Orders', 'value' => '1,284', 'trend' => '+8.4%', 'trend_class' => 'kpi-up'),
                array('title' => 'Avg. Order Value', 'value' => '$38.10', 'trend' => '+3.1%', 'trend_class' => 'kpi-up'),
                array('title' => 'Low Stock SKUs', 'value' => '37', 'trend' => '-4.2%', 'trend_class' => 'kpi-down')
            )
        );

        $this->render('dashboard', $data);
    }

    /*public function products()
    {
        $data = array(
            'active' => 'products',
            'title' => 'Products',
            'subtitle' => 'Manage catalog across all packaging and stationery categories.',
            'table_title' => 'Saved Products',
            'headers' => array('SKU', 'Product', 'Category', 'Price', 'Stock', 'Visibility'),
            'rows' => array(
                array('GB-50L-BLK', 'Heavy Duty Garbage Bag 50L', 'Plastic Bags', '$4.20', '2480', 'Live'),
                array('ST-PP-A4', 'A4 Copier Paper Bundle', 'Stationery', '$7.95', '420', 'Live'),
                array('SF-ROLL-1KG', 'Silver Foil Sheet Roll 1kg', 'Silver Foil', '$12.70', '0', 'Draft'),
                array('RF-TS-100', 'RFID Tamper Seal - Pack of 100', 'RFID Seals', '$29.00', '110', 'Live')
            )
        );

        $this->render('master_table', $data);
    }*/

    public function products()
    {
        $this->load->model('Products_model');
        $this->load->model('Category_model');
        $this->load->model('Sub_category_model');
        $this->load->model('Attribute_model');


        $data = array(
        'active' => 'products',
        'title' => 'Products',
       'subtitle' => 'Manage catalog across all packaging and stationery categories.',
        'products' => $this->Products_model->get_product_list(), // ✅ DB DATA
        'categories' => $this->Category_model->get_categories(),
        'subcategories' => $this->Sub_category_model->get_all_subcategories(),
        'attributes' => $this->Attribute_model->get_attributes(),
        'status_options' => array('Active', 'Review', 'Draft')

        );

        $this->render('products', $data);




    }

    public function categories()
{
    $this->load->model('Category_model');

    $data = array(
        'active' => 'categories',
     'title' => 'Categories',
    'subtitle' => 'Category structure for plastic and paper packaging catalog.',
        'categories' => $this->Category_model->get_categories(), // ✅ DB DATA
        'status_options' => array('Active', 'Review', 'Draft')
    );

    $this->render('categories', $data);
}

 /*
    public function categories()
    {
        $data = array(
            'active' => 'categories',
            'title' => 'Categories',
            'subtitle' => 'Category structure for plastic and paper packaging catalog.',
            'categories' => array(
                array(
                    'name' => 'Plastic Garbage Bags',
                    'slug' => 'plastic-garbage-bags',
                    'subcategories' => 'Compostable, Heavy Duty',
                    'products' => '84',
                    'status' => 'Active',
                    'description' => 'Waste disposal bags for home, retail, hospitality, and industrial usage.'
                ),
                array(
                    'name' => 'Stationery Materials',
                    'slug' => 'stationery-materials',
                    'subcategories' => 'Paper, Adhesives',
                    'products' => '142',
                    'status' => 'Active',
                    'description' => 'Office-use stationery, paper bundles, tapes, labels, and utility consumables.'
                ),
                array(
                    'name' => 'Silver Foil Papers',
                    'slug' => 'silver-foil-papers',
                    'subcategories' => 'Rolls, Sheets',
                    'products' => '26',
                    'status' => 'Active',
                    'description' => 'Food-grade foil rolls and sheets for packing, catering, and kitchen supply.'
                ),
                array(
                    'name' => 'RFID Seals',
                    'slug' => 'rfid-seals',
                    'subcategories' => 'Tamper, Barcode',
                    'products' => '12',
                    'status' => 'Active',
                    'description' => 'Security tags and RFID-enabled tamper seals for logistics and stock control.'
                ),
                array(
                    'name' => 'Paper Bags',
                    'slug' => 'paper-bags',
                    'subcategories' => 'Carry, Grocery',
                    'products' => '53',
                    'status' => 'Review',
                    'description' => 'Retail and grocery-grade paper carry bags in multiple handle and GSM options.'
                )
            ),
            'status_options' => array('Active', 'Review', 'Draft')
        );

        $this->render('categories', $data);
    }*/

    public function orders()
    {
        $this->load->model('Order_model');
        $data = array(
            'active' => 'orders',
            'title' => 'Orders',
            'subtitle' => 'Track fulfillment, shipping, and returns.',
            'table_title' => 'Saved Orders',
            'headers' => array("Order", "Customer", "Amount", "Products", "Items", "Status", "Date"),
           "rows" => $this->Order_model->get_orders_for_admin()
        );

        $this->render('orders', $data);
    }

    public function order_detail($order_id = 0)
    {
        $this->load->model('Order_model');
        $order_id = (int) $order_id;

        if (strtoupper($this->input->method()) === 'POST' && $order_id > 0) {
            $order_status = trim((string) $this->input->post('order_status'));
            if ($order_status !== '') {
                $this->Order_model->update_order_status($order_id, array(
                    'order_status' => $order_status
                ));
            }

            redirect('admin/orders/' . $order_id . '?updated=1');
            return;
        }

        $order = $this->Order_model->get_order_detail_for_admin($order_id);

        if (!$order) {
            show_404();
        }

        $data = array(
            'active' => 'orders',
            'title' => 'Order Detail',
            'subtitle' => 'Review customer, products, payment, and shipping information in one place.',
            'order' => $order,
            'order_items' => $this->Order_model->get_order_items_for_admin($order_id),
            'status_options' => array('pending', 'confirmed', 'packed', 'shipped', 'delivered', 'cancelled', 'returned'),
            'updated' => (bool) $this->input->get('updated')
        );

        $this->render('order_detail', $data);
    }


  /*  
    public function invoice($invoice_id = 0)
    {
        $invoice_id = (int) $invoice_id;

        $data = array(
            'active' => 'invoice',
            'title' => 'Invoice',
            'subtitle' => 'Design-only invoice preview for admin use and future generation workflow.',
            'invoice_meta' => array(
                'invoice_no' => 'PM-INV-2026-001',
                'order_no' => 'PM-0007',
                'invoice_date' => '06 May 2026',
                'due_date' => '13 May 2026',
                'status' => 'Draft',
                'invoice_id' => $invoice_id
            ),
            'billing' => array(
                'customer_name' => 'Shakti Traders',
                'company_name' => 'Shakti Traders Pvt. Ltd.',
                'address' => '120, Industrial Estate, Andheri East, Mumbai, Maharashtra 400059',
                'phone' => '+91 98765 43210',
                'email' => 'billing@shaktitraders.in',
                'gst' => '27AAECS1234F1Z5'
            ),
            'summary' => array(
                'sub_total' => '₹12,480.00',
                'discount' => '₹480.00',
                'tax' => '₹2,160.00',
                'shipping' => '₹0.00',
                'grand_total' => '₹14,160.00'
            ),
            'items' => array(
                array('sku' => 'GB-50L-BLK', 'name' => 'Heavy Duty Garbage Bag 50L', 'qty' => 10, 'rate' => '₹420.00', 'amount' => '₹4,200.00'),
                array('sku' => 'RF-TS-100', 'name' => 'RFID Tamper Seal Pack of 100', 'qty' => 4, 'rate' => '₹1,850.00', 'amount' => '₹7,400.00'),
                array('sku' => 'SF-ROLL-1KG', 'name' => 'Silver Foil Sheet Roll 1kg', 'qty' => 2, 'rate' => '₹440.00', 'amount' => '₹880.00')
            )
        );

        $this->render('invoice', $data);
    }
*/


/*
public function invoice($invoice_id = 0)
{
    $invoice_id = (int) $invoice_id;

    // ✅ Get order
    $order = $this->db
        ->where('id', $invoice_id)
        ->get('order_tbl')
        ->row();

    if (!$order) {
        show_404();
    }

    // ✅ Get customer
    $customer = $this->db
        ->where('id', $order->user_id)
        ->get('users_tbl')
        ->row();

    // ✅ Get order items
    $items = $this->db
        ->where('order_id', $order->id)
        ->get('order_items_tbl')
        ->result();

    // ✅ Invoice items array
    $invoice_items = [];

    foreach ($items as $item) {

        $invoice_items[] = array(
            'sku'    => $item->sku ?? '-',
            'name'   => $item->product_name ?? '',
            'qty'    => $item->quantity ?? 0,
            'rate'   => '₹' . number_format($item->price ?? 0, 2),
            'amount' => '₹' . number_format(($item->price ?? 0) * ($item->quantity ?? 0), 2)
        );
    }

    // ✅ Pass dynamic data
    $data = array(

        'active' => 'invoice',

        'title' => 'Invoice',

        'subtitle' => 'Invoice Preview',

        'invoice_meta' => array(
            'invoice_no'  => 'PM-INV-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),

            'order_no'    => 'PM-' . str_pad($order->id, 4, '0', STR_PAD_LEFT),

            'invoice_date'=> !empty($order->created_at)
                ? date('d M Y', strtotime($order->created_at))
                : date('d M Y'),

            'due_date'    => !empty($order->created_at)
                ? date('d M Y', strtotime($order->created_at . ' +7 days'))
                : date('d M Y'),

            'status'      => ucfirst($order->order_status ?? 'Pending'),

            'invoice_id'  => $order->id
        ),

        'billing' => array(
            'customer_name' => $customer->name ?? '',
            'company_name'  => $customer->company_name ?? '',
            'address'       => $customer->address ?? '',
            'phone'         => $customer->mobile ?? '',
            'email'         => $customer->email ?? '',
            'gst'           => $customer->gst_number ?? ''
        ),

        'summary' => array(
            'sub_total'   => '₹' . number_format($order->subtotal ?? 0, 2),

            'discount'    => '₹' . number_format($order->discount_value ?? 0, 2),

            'tax'         => '₹' . number_format($order->gst ?? 0, 2),

            'shipping'    => '₹' . number_format($order->shipping_charge ?? 0, 2),

            'grand_total' => '₹' . number_format($order->total_amount ?? 0, 2)
        ),

        'items' => $invoice_items
    );

    $this->render('invoice', $data);
}


  */

/*
public function invoice($invoice_id = 0)
{
    $invoice_id = (int) $invoice_id;

    // ✅ Get Order
    $order = $this->db
        ->where('id', $invoice_id)
        ->get('order_tbl')
        ->row();

    if (!$order) {
        show_404();
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
            product_tbl.sku
        ')
        ->from('order_items_tbl')
        ->join(
            'product_tbl',
            'product_tbl.id = order_items_tbl.product_id',
            'left'
        )
        ->where('order_items_tbl.order_id', $order->id)
        ->get()
        ->result();

    // ✅ Invoice Items Array
    $invoice_items = [];

    foreach ($items as $item) {

        $invoice_items[] = array(

            'sku' => $item->sku ?? '-',

            'name' => $item->product_name ?? '',

            'qty' => $item->quantity ?? 0,

            'rate' => '₹' . number_format($item->price ?? 0, 2),

            'amount' => '₹' . number_format(
                ($item->price ?? 0) * ($item->quantity ?? 0),
                2
            )
        );
    }

    // ✅ Final Data
    $data = array(

        'active' => 'invoice',

        'title' => 'Invoice',

        'subtitle' => 'Invoice Preview',

        'invoice_meta' => array(

            'invoice_no' => 'PM-INV-' . str_pad(
                $order->id,
                4,
                '0',
                STR_PAD_LEFT
            ),

            'order_no' => 'PM-' . str_pad(
                $order->id,
                4,
                '0',
                STR_PAD_LEFT
            ),

            'invoice_date' => !empty($order->created_at)
                ? date('d M Y', strtotime($order->created_at))
                : date('d M Y'),

            'due_date' => !empty($order->created_at)
                ? date(
                    'd M Y',
                    strtotime($order->created_at . ' +7 days')
                )
                : date('d M Y'),

            'status' => ucfirst(
                $order->order_status ?? 'Pending'
            ),

            'invoice_id' => $order->id
        ),

        'billing' => array(

            'customer_name' => trim(
                ($customer->firstname ?? '') . ' ' .
                ($customer->lastname ?? '')
            ),

            'company_name' => '',

            'address' => ($customer->address ?? ''). ', ' .
                ($customer->city ?? '') . ', ' .
                ($customer->state ?? '') . ' , ' .
                ($customer->country ?? '') . ' , ' .
                ($customer->pincode ?? ''),
            

            'phone' => $customer->phone_no ?? '',

            'email' => $customer->email ?? '',

            'gst' => '27AAECS1234F1Z5'
        ),

        'summary' => array(

            'sub_total' => '₹' . number_format(
                $order->subtotal ?? 0,
                2
            ),

            'discount' => '₹' . number_format(
                $order->discount_value ?? 0,
                2
            ),

            'tax' => '₹' . number_format(
                $order->gst ?? 0,
                2
            ),

            'shipping' => '₹' . number_format(
                $order->shipping ?? 0,
                2
            ),

            'grand_total' => '₹' . number_format(
                $order->total_amount ?? 0,
                2
            )
        ),

        'items' => $invoice_items
    );

    $this->render('invoice', $data);
}*/

public function invoice($invoice_id = 0)
{
    $invoice_id = (int) $invoice_id;

    // ✅ Get Order
    $order = $this->db
        ->where('id', $invoice_id)
        ->get('order_tbl')
        ->row();

    if (!$order) {
        show_404();
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
        ->where('order_items_tbl.order_id', $order->id)
        ->get()
        ->result();

    // ✅ Invoice Items Array
    $invoice_items = [];

    foreach ($items as $item) {

        $qty = $item->quantity ?? 0;

        $rate = $item->product_price ?? 0;

        $amount = $rate * $qty;

        $invoice_items[] = array(

            'sku' => $item->sku ?? '-',

            'name' => $item->product_name ?? '',

            'qty' => $qty,

            'rate' => '₹' . number_format($rate, 2),

            'amount' => '₹' . number_format($amount, 2)
        );
    }

    // ✅ Final Data

    // ✅ Get Selected Address
        $address = $this->db
            ->where('id', $order->address_id)
            ->get('address_book_tbl')
            ->row();
    $data = array(

        'active' => 'invoice',

        'title' => 'Invoice',

        'subtitle' => 'Invoice Preview',

        'invoice_meta' => array(

            'invoice_no' => 'PM-INV-' . str_pad(
                $order->id,
                4,
                '0',
                STR_PAD_LEFT
            ),

            'order_no' => 'PM-' . str_pad(
                $order->id,
                4,
                '0',
                STR_PAD_LEFT
            ),

            'invoice_date' => !empty($order->created_at)
                ? date('d M Y', strtotime($order->created_at))
                : date('d M Y'),

            'due_date' => !empty($order->created_at)
                ? date(
                    'd M Y',
                    strtotime($order->created_at . ' +7 days')
                )
                : date('d M Y'),

            'status' => ucfirst(
                $order->order_status ?? 'Pending'
            ),

            'invoice_id' => $order->id
        ),

        'billing' => array(

            'customer_name' => trim(
                ($customer->firstname ?? '') . ' ' .
                ($customer->lastname ?? '')
            ),

            'company_name' => '',

            'address' => trim(
                ($address->address ?? '') . ', ' .
                ($address->city ?? '') . ', ' .
                ($address->state ?? '') . ', ' .
                ($address->country ?? '') . ', ' .
                ($address->pincode ?? ''),
                ', '
            ),

            'phone' => $customer->phone_no ?? '',

            'email' => $customer->email ?? '',

            'gst' => '27AAECS1234F1Z5'
        ),

        'summary' => array(

            'sub_total' => '₹' . number_format(
                $order->subtotal ?? 0,
                2
            ),

            'discount' => '₹' . number_format(
                $order->discount_value ?? 0,
                2
            ),

            'tax' => '₹' . number_format(
                $order->gst ?? 0,
                2
            ),

            'shipping' => '₹' . number_format(
                $order->shipping ?? 0,
                2
            ),

            'grand_total' => '₹' . number_format(
                $order->total_amount ?? 0,
                2
            )
        ),

        'items' => $invoice_items
    );

    $this->render('invoice', $data);
}

    public function customers()
    {
        $data = array(
            'active' => 'customers',
            'title' => 'Customers',
            'subtitle' => 'B2B and retail customer records and segments.',
            'table_title' => 'Saved Customers',
            'headers' => array('Name', 'Type', 'Total Spend', 'Last Order', 'Status'),
            'rows' => array(
                array('Retail Mart Pvt.', 'Wholesale', '$12,430', '05 Mar 2026', 'Active'),
                array('Shakti Traders', 'Reseller', '$8,910', '05 Mar 2026', 'Active'),
                array('Prime Supplies', 'Corporate', '$4,334', '04 Mar 2026', 'Active'),
                array('Westline Stores', 'Retail', '$1,920', '04 Mar 2026', 'At Risk')
            )
        );

        $this->render('master_table', $data);
    }

    public function inventory()
    {
        $data = array(
            'active' => 'inventory',
            'title' => 'Inventory',
            'subtitle' => 'Warehouse stock status and replenishment controls.',
            'table_title' => 'Saved Inventory',
            'headers' => array('SKU', 'Product', 'Warehouse', 'Available', 'Reorder Level', 'Status'),
            'rows' => array(
                array('GB-50L-BLK', 'Heavy Duty Garbage Bag 50L', 'Mumbai-A', '2480', '700', 'Healthy'),
                array('RF-TS-100', 'RFID Tamper Seal - 100', 'Mumbai-A', '110', '150', 'Reorder'),
                array('SF-ROLL-1KG', 'Silver Foil Sheet Roll 1kg', 'Pune-B', '0', '80', 'Urgent'),
                array('PB-STD-MED', 'Paper Carry Bag Medium', 'Pune-B', '340', '220', 'Healthy')
            )
        );

        $this->render('master_table', $data);
    }


    public function subcategories()
{
    $this->load->model('Category_model');
    $this->load->model('Sub_category_model');

    $data = array(
        'active' => 'subcategories',
       'title' => 'Subcategories',
       'subtitle' => 'Manage subcategories linked with categories.',
        'categories' => $this->Category_model->get_categories(),
        'subcategories' => $this->Sub_category_model->get_all_subcategories()
    );

    $this->render('subcategories', $data);
}
    public function suppliers()
    {
        $data = array(
            'active' => 'suppliers',
            'title' => 'Suppliers',
            'subtitle' => 'Vendor contracts for plastic and paper sourcing.',
            'table_title' => 'Saved Suppliers',
            'headers' => array('Supplier', 'Category', 'Lead Time', 'Quality Score', 'Contract'),
            'rows' => array(
                array('Nova Polychem', 'Plastic Bags', '4 days', '96%', 'Active'),
                array('SilvoWrap Industries', 'Silver Foil', '6 days', '89%', 'Active'),
                array('TagSecure Systems', 'RFID Seals', '5 days', '92%', 'Active'),
                array('PaperNest LLP', 'Paper Bags', '8 days', '83%', 'Expiring')
            )
        );

        $this->render('master_table', $data);
    }


    public function promotions()
    {
        $this->load->model('Promotion_model');

        $data = array(
            'active' => 'promotions',
            'title' => 'Promotions',
            'subtitle' => 'Manage discount coupons and bulk offers.',
            'promotions' => $this->Promotion_model->get_promotions(), // ✅ DB DATA
            'coupon_types' => array('OrderValue', 'Category', 'Product', 'FirstOrder'),
            'coupon_status_options' => array('Active', 'Scheduled', 'Expired', 'Draft')
        );

        $this->render('promotions', $data);
    }

   /* public function promotions()
    {
        $data = array(
            'active' => 'promotions',
            'title' => 'Promotions',
            'subtitle' => 'Manage discount coupons and bulk offers.',
            'coupons' => array(
                array(
                    'code' => 'BULK5',
                    'type' => 'Order Value',
                    'discount' => '5%',
                    'validity' => 'Mar 01 - Mar 31',
                    'usage' => '128',
                    'status' => 'Active',
                    'description' => 'Applied on bulk orders above the minimum cart value.'
                ),
                array(
                    'code' => 'RFID10',
                    'type' => 'Category',
                    'discount' => '10%',
                    'validity' => 'Mar 05 - Mar 15',
                    'usage' => '14',
                    'status' => 'Active',
                    'description' => 'Discount for all RFID seal products.'
                ),
                array(
                    'code' => 'WELCOME15',
                    'type' => 'First Order',
                    'discount' => '15%',
                    'validity' => 'Feb 01 - Apr 01',
                    'usage' => '230',
                    'status' => 'Active',
                    'description' => 'Introductory coupon for first-time buyers.'
                ),
                array(
                    'code' => 'FOILFEST',
                    'type' => 'Product',
                    'discount' => '$3 off',
                    'validity' => 'Mar 10 - Mar 20',
                    'usage' => '0',
                    'status' => 'Scheduled',
                    'description' => 'Upcoming promotional coupon for foil products.'
                )
            ),
            'coupon_types' => array('Order Value', 'Category', 'Product', 'First Order'),
            'coupon_status_options' => array('Active', 'Scheduled', 'Expired', 'Draft')
        );

        $this->render('promotions', $data);
    }*/

    /*

    public function reports()
    {
            $this->load->model('Order_model');
           // $date_range = $this->input->get('date_range') ?? 'today';
            //$order_status_filter = $this->input->get('order_status') ?? 'all';

        $data = array(
            'active' => 'reports',
            'title' => 'Sales Report',
            'subtitle' => 'Sales performance view designed for ecommerce reporting and Excel export.',
            'kpis'=>$this->Order_model->get_by_kpis(),
              //  'sales_trend'=>$this->Order_model->get_sales_trend(),
                //'summary_cards'=>$this->Order_model->get_summary_cards(),
                //'sales_rows'=>$this->Order_model->get_sales_rows(),
        
         /*  'kpis' => array(
                array('title' => 'Gross Sales', 'value' => '₹12.48L', 'trend' => '+18.2%', 'trend_class' => 'kpi-up'),
                array('title' => 'Net Sales', 'value' => '₹9.86L', 'trend' => '+14.7%', 'trend_class' => 'kpi-up'),
                array('title' => 'Orders', 'value' => '1,284', 'trend' => '+8.4%', 'trend_class' => 'kpi-up'),
                array('title' => 'Avg. Order Value', 'value' => '₹971', 'trend' => '+3.1%', 'trend_class' => 'kpi-up')
            ),*/
         /*   'sales_trend' => array(
                array('label' => 'Mon', 'value' => 36),
                array('label' => 'Tue', 'value' => 42),
                array('label' => 'Wed', 'value' => 58),
                array('label' => 'Thu', 'value' => 48),
                array('label' => 'Fri', 'value' => 66),
                array('label' => 'Sat', 'value' => 74),
                array('label' => 'Sun', 'value' => 51)
            ),*/
         /*   'summary_cards' => array(
                array('label' => 'Top Channel', 'value' => 'Website', 'note' => '48% of orders'),
                array('label' => 'Best Category', 'value' => 'Plastic Bags', 'note' => 'Highest revenue'),
                array('label' => 'Highest Day', 'value' => 'Saturday', 'note' => 'Peak order volume'),
                array('label' => 'Refund Rate', 'value' => '2.3%', 'note' => 'Rolling 30 days')
            ),*/
           /*'sales_rows' => array(
                array('date' => '06 May 2026', 'orders' => 128, 'items' => 420, 'gross' => '₹1.48L', 'discount' => '₹4,800', 'net' => '₹1.43L', 'channel' => 'Website'),
                array('date' => '05 May 2026', 'orders' => 116, 'items' => 388, 'gross' => '₹1.36L', 'discount' => '₹3,900', 'net' => '₹1.32L', 'channel' => 'WhatsApp'),
                array('date' => '04 May 2026', 'orders' => 103, 'items' => 352, 'gross' => '₹1.21L', 'discount' => '₹2,700', 'net' => '₹1.18L', 'channel' => 'Website'),
                array('date' => '03 May 2026', 'orders' => 97, 'items' => 311, 'gross' => '₹1.08L', 'discount' => '₹2,200', 'net' => '₹1.06L', 'channel' => 'Marketplace'),
                array('date' => '02 May 2026', 'orders' => 88, 'items' => 295, 'gross' => '₹98K', 'discount' => '₹1,900', 'net' => '₹96K', 'channel' => 'Sales Team')
            ),*/
         /*   'sales_rows' => $this->Order_model->get_sales_report_by_today(date('Y-m-d'), 'all'),
        );

        $this->render('reports', $data);
    }


    */

    //report admin

    public function reports()
    {
        $this->load->model('Order_model');

        $date_range = $this->input->get('date_range');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $status = $this->input->get('order_status');

        if (empty($date_range)) {
            $date_range = 'month';
        }

        if (empty($status)) {
            $status = 'all';
        }

        if (empty($start_date)) {
            $start_date = date('Y-m-01');
        }

        if (empty($end_date)) {
            $end_date = date('Y-m-t');
        }

        $data = array(
            'active' => 'reports_sales',
            'title' => 'Sales Report',
            'subtitle' => 'Sales performance view designed for ecommerce reporting and Excel export.',
            'kpi' => $this->Order_model->get_by_kpis($start_date, $end_date, $status),
            'sales_rows' => $this->Order_model->get_sales_report($start_date, $end_date, $status),
            'selected_status' => $status,
            'date_range' => $date_range,
            'start_date' => $start_date,
            'end_date' => $end_date
        );

        $this->render('reports', $data);
    }



/*
    public function gst_sales_summary()
    {
        $data = array(
            'active' => 'reports_gst',
            'title' => 'GST Sales Summary',
            'subtitle' => 'Design-only GST summary report for ecommerce sales, tax breakup, and export review.',
            'kpis' => array(
                array('title' => 'Taxable Value', 'value' => '₹9.86L', 'trend' => '+14.7%', 'trend_class' => 'kpi-up'),
                array('title' => 'CGST', 'value' => '₹88.4K', 'trend' => '+12.1%', 'trend_class' => 'kpi-up'),
                array('title' => 'SGST', 'value' => '₹88.4K', 'trend' => '+12.1%', 'trend_class' => 'kpi-up'),
                array('title' => 'IGST', 'value' => '₹24.7K', 'trend' => '+8.4%', 'trend_class' => 'kpi-up')
            ),
            'summary_cards' => array(
                array('label' => 'Invoices Issued', 'value' => '1,284', 'note' => 'B2B + retail'),
                array('label' => 'B2B Share', 'value' => '68%', 'note' => 'Business orders'),
                array('label' => 'B2C Share', 'value' => '32%', 'note' => 'Retail orders'),
                array('label' => 'Zero Rated', 'value' => '24', 'note' => 'No tax applied')
            ),
            'gst_rate_rows' => array(
                array('rate' => '0%', 'taxable' => '₹1.24L', 'invoices' => '24', 'cgst' => '₹0', 'sgst' => '₹0', 'igst' => '₹0'),
                array('rate' => '5%', 'taxable' => '₹2.06L', 'invoices' => '318', 'cgst' => '₹5.15K', 'sgst' => '₹5.15K', 'igst' => '₹0'),
                array('rate' => '12%', 'taxable' => '₹3.42L', 'invoices' => '412', 'cgst' => '₹20.52K', 'sgst' => '₹20.52K', 'igst' => '₹9.31K'),
                array('rate' => '18%', 'taxable' => '₹3.14L', 'invoices' => '460', 'cgst' => '₹28.26K', 'sgst' => '₹28.26K', 'igst' => '₹15.40K')
            ),
            'gst_invoice_rows' => array(
                array('invoice' => 'PM-INV-2026-001', 'date' => '06 May 2026', 'customer' => 'Shakti Traders', 'state' => 'Maharashtra', 'taxable' => '₹48,000', 'gst' => '₹8,640', 'total' => '₹56,640'),
                array('invoice' => 'PM-INV-2026-002', 'date' => '05 May 2026', 'customer' => 'Prime Supplies', 'state' => 'Gujarat', 'taxable' => '₹22,500', 'gst' => '₹2,700', 'total' => '₹25,200'),
                array('invoice' => 'PM-INV-2026-003', 'date' => '04 May 2026', 'customer' => 'Retail Mart', 'state' => 'Maharashtra', 'taxable' => '₹31,200', 'gst' => '₹5,616', 'total' => '₹36,816'),
                array('invoice' => 'PM-INV-2026-004', 'date' => '03 May 2026', 'customer' => 'Westline Stores', 'state' => 'Delhi', 'taxable' => '₹18,750', 'gst' => '₹3,375', 'total' => '₹22,125'),
                array('invoice' => 'PM-INV-2026-005', 'date' => '02 May 2026', 'customer' => 'City Wholesale', 'state' => 'Karnataka', 'taxable' => '₹42,000', 'gst' => '₹7,560', 'total' => '₹49,560'),
                array('invoice' => 'PM-INV-2026-006', 'date' => '01 May 2026', 'customer' => 'Northline Retail', 'state' => 'Tamil Nadu', 'taxable' => '₹27,800', 'gst' => '₹5,004', 'total' => '₹32,804')
            ),
            'state_wise_rows' => array(
                array('state' => 'Maharashtra', 'taxable' => '₹1.24L', 'gst' => '₹22.32K', 'invoices' => '412'),
                array('state' => 'Gujarat', 'taxable' => '₹86K', 'gst' => '₹10.32K', 'invoices' => '164'),
                array('state' => 'Delhi', 'taxable' => '₹74K', 'gst' => '₹13.32K', 'invoices' => '98'),
                array('state' => 'Karnataka', 'taxable' => '₹66K', 'gst' => '₹11.88K', 'invoices' => '84'),
                array('state' => 'Tamil Nadu', 'taxable' => '₹58K', 'gst' => '₹10.44K', 'invoices' => '71')
            ),
            'start_date' => date('Y-m-01'),
            'end_date' => date('Y-m-t')
        );

        $this->render('gst_sales_summary', $data);
    }
*/

public function gst_sales_summary()
{
    // Filters
    $date_range = $this->input->get('date_range');

    $start_date = $this->input->get('start_date');

    $end_date = $this->input->get('end_date');

    // Load model
    $this->load->model('Order_model');

    // Fetch data
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // KPI Variables
    $taxable_value = 0;
    $cgst = 0;
    $sgst = 0;
    $igst = 0;

    // Invoice rows
    $gst_invoice_rows = [];

    foreach ($report as $row) {

        $taxable_value += $row['sub_total'];

        // Maharashtra = CGST + SGST
        if (
            strtolower(trim($row['state']))
            == 'maharashtra'
        ) {

            $cgst += ($row['tax'] / 2);

            $sgst += ($row['tax'] / 2);

        } else {

            $igst += $row['tax'];
        }

        // Dynamic table rows
        $gst_invoice_rows[] = [

            'invoice' => $row['invoice_no'],

            'date' => date(
                'd M Y',
                strtotime($row['invoice_date'])
            ),

            'customer' => $row['customer_name'],

            'state' => $row['state'],

            'taxable' => '₹' .
                number_format(
                    $row['sub_total'],
                    2
                ),

            'gst' => '₹' .
                number_format(
                    $row['tax'],
                    2
                ),

            'total' => '₹' .
                number_format(
                    $row['grand_total'],
                    2
                )
        ];
    }

    // Final view data
    $data = [

        'active' => 'reports_gst',

        'title' => 'GST Sales Summary',

        'subtitle' =>
            'Dynamic GST summary report',

        // Dynamic KPI cards
        'kpis' => [

            [
                'title' => 'Taxable Value',

                'value' => '₹' .
                    number_format(
                        $taxable_value,
                        2
                    ),

                'trend' => '',

                'trend_class' => 'kpi-up'
            ],

            [
                'title' => 'CGST',

                'value' => '₹' .
                    number_format(
                        $cgst,
                        2
                    ),

                'trend' => '',

                'trend_class' => 'kpi-up'
            ],

            [
                'title' => 'SGST',

                'value' => '₹' .
                    number_format(
                        $sgst,
                        2
                    ),

                'trend' => '',

                'trend_class' => 'kpi-up'
            ],

            [
                'title' => 'IGST',

                'value' => '₹' .
                    number_format(
                        $igst,
                        2
                    ),

                'trend' => '',

                'trend_class' => 'kpi-up'
            ]
        ],

        // Dynamic table
        'gst_invoice_rows' => $gst_invoice_rows,

        'start_date' => date('Y-m-01'),

        'end_date' => date('Y-m-t')
    ];

    $this->render('gst_sales_summary', $data);
    
}
  
public function statewise_gst_report()
{

    // FILTERS
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // DEFAULT
    if (empty($date_range)) {

        $date_range = 'month';
    }

    // LOAD MODEL
    $this->load->model('Order_model');

    // STATEWISE REPORT
    $state_wise_rows =
        $this->Order_model
            ->get_statewise_gst_report(
                $date_range,
                $start_date,
                $end_date
            );

    // SUMMARY VARIABLES
    $total_states = 0;

    $highest_state = '-';

    $highest_value = 0;

    $igst_states = 0;

    $total_gst = 0;

    $tax_buckets = array();

    // PROCESS DATA
    if (!empty($state_wise_rows)) {

        $total_states =
            count($state_wise_rows);

        // FIRST FIND HIGHEST VALUE
        foreach ($state_wise_rows as $row) {

            if (
                $row['sub_total']
                > $highest_value
            ) {

                $highest_value =
                    $row['sub_total'];

                $highest_state =
                    $row['state'];
            }
        }

        // MAIN LOOP
        foreach ($state_wise_rows as $row) {

            // TOTAL GST
            $total_gst +=
                (float)$row['tax'];

            // IGST STATES
            if (
                strtolower($row['state'])
                != 'maharashtra'
            ) {

                $igst_states++;
            }

            // BAR %
            $bar =
                $highest_value > 0
                ? (
                    $row['sub_total']
                    / $highest_value
                ) * 100
                : 0;

            $tax_buckets[] = array(

                'label' =>
                    $row['state'],

                'bar' =>
                    round($bar)
            );
        }
    }

    // SUMMARY CARDS
    $summary_cards = array(

        array(
            'label' => 'Total States',
            'value' => $total_states,
            'note' => 'Active tax regions'
        ),

        array(
            'label' => 'Highest State',
            'value' => $highest_state,
            'note' => 'Top taxable value'
        ),

        array(
            'label' => 'IGST States',
            'value' => $igst_states,
            'note' => 'Inter-state supply'
        ),

        array(
            'label' => 'GST Collected',
            'value' => '₹' .
                number_format(
                    $total_gst,
                    2
                ),
            'note' => 'All states combined'
        )
    );

    // VIEW DATA
    $data = array(

        'active' =>
            'reports_statewise',

        'title' =>
            'Statewise GST',

        'subtitle' =>
            'Dynamic statewise GST report for ecommerce sales review and export.',

        'date_range' =>
            $date_range,

        'start_date' =>
            !empty($start_date)
            ? $start_date
            : date('Y-m-01'),

        'end_date' =>
            !empty($end_date)
            ? $end_date
            : date('Y-m-t'),

        'state_wise_rows' =>
            $state_wise_rows,

        'summary_cards' =>
            $summary_cards,

        'tax_buckets' =>
            $tax_buckets
    );

    $this->render(
        'statewise_gst_report',
        $data
    );
}
/*
public function statewise_gst_report()
    {
        $data = array(
            'active' => 'reports_statewise',
            'title' => 'Statewise GST',
            'subtitle' => 'Design-only statewise GST report for ecommerce sales review and export.',
            'date_range' => 'month',
            'start_date' => date('Y-m-01'),
            'end_date' => date('Y-m-t'),
            'state_wise_rows' => array(
                array('state' => 'Maharashtra', 'taxable' => '₹1.24L', 'gst' => '₹22.32K', 'invoices' => '412'),
                array('state' => 'Gujarat', 'taxable' => '₹86K', 'gst' => '₹10.32K', 'invoices' => '164'),
                array('state' => 'Delhi', 'taxable' => '₹74K', 'gst' => '₹13.32K', 'invoices' => '98'),
                array('state' => 'Karnataka', 'taxable' => '₹66K', 'gst' => '₹11.88K', 'invoices' => '84'),
                array('state' => 'Tamil Nadu', 'taxable' => '₹58K', 'gst' => '₹10.44K', 'invoices' => '71'),
                array('state' => 'Telangana', 'taxable' => '₹41K', 'gst' => '₹7.38K', 'invoices' => '52')
            ),
            'summary_cards' => array(
                array('label' => 'Total States', 'value' => '6', 'note' => 'Active tax regions'),
                array('label' => 'Highest State', 'value' => 'Maharashtra', 'note' => 'Top taxable value'),
                array('label' => 'IGST States', 'value' => '3', 'note' => 'Inter-state supply'),
                array('label' => 'GST Collected', 'value' => '₹75.98K', 'note' => 'All states combined')
            ),
            'tax_buckets' => array(
                array('label' => 'Maharashtra', 'bar' => 100),
                array('label' => 'Gujarat', 'bar' => 72),
                array('label' => 'Delhi', 'bar' => 61),
                array('label' => 'Karnataka', 'bar' => 54),
                array('label' => 'Tamil Nadu', 'bar' => 46),
                array('label' => 'Telangana', 'bar' => 33)
            )
        );

        $this->render('statewise_gst_report', $data);
    }
*/
    /*
    public function reports()
{
    $this->load->model('Order_model');

    $date_range = $this->input->get('date_range');

    $start_date = $this->input->get('start_date');
    $end_date   = $this->input->get('end_date');

    $status     = $this->input->get('order_status');

    // Default date range
    if (empty($date_range)) {
        $date_range = 'last_7_days';
    }

    // Default dates
    if (empty($start_date)) {
        $start_date = date('Y-m-d', strtotime('-7 days'));
    }

    if (empty($end_date)) {
        $end_date = date('Y-m-d');
    }

    // Default status
    if (empty($status)) {
        $status = 'all';
    }

    $data = array(

        'active'   => 'reports',

        'title'    => 'Sales Report',

        'subtitle' => 'Sales performance view designed for ecommerce reporting and Excel export.',

        'kpi' => $this->Order_model->get_by_kpis(
            $start_date,
            $end_date,
            $status
        ),

        'sales_rows' => $this->Order_model->get_sales_report(
            $start_date,
            $end_date,
            $status
        ),

        'selected_status' => $status,

        'date_range' => $date_range,

        'start_date' => $start_date,

        'end_date'   => $end_date

    );

    $this->render('reports', $data);
}

/*
    public function reports()
{
    $this->load->model('Order_model');

    $start_date = $this->input->get('start_date');
    $end_date   = $this->input->get('end_date');
    $status     = $this->input->get('order_status');

    // Default dates
    if (empty($start_date)) {
        $start_date = date('Y-m-d', strtotime('-7 days'));
    }

    if (empty($end_date)) {
        $end_date = date('Y-m-d');
    }

    // Default status
    if (empty($status)) {
        $status = 'all';
    }

    $data = array(

        'active'   => 'reports',
        'title'    => 'Sales Report',
        'subtitle' => 'Sales performance view designed for ecommerce reporting and Excel export.',

        'kpi' => $this->Order_model->get_by_kpis(
            $start_date,
            $end_date,
            $status
        ),

        'sales_rows' => $this->Order_model->get_sales_report_by_custom_date_range(
            $start_date,
            $end_date,
            $status
        ),

        'selected_status' => $status,

         'start_date' => $start_date,
         'end_date'   => $end_date

           

    );

    $this->render('reports', $data);
}*/
/*
public function reports()
{
    $this->load->model('Order_model');

  //  $day_ago = date('Y-m-d', strtotime('-8 days'));
   // $start_date = date('Y-m-d', strtotime('-7 days'));
   // $days_ago = date('Y-m-d', strtotime('-7 days'));
   // $start_date = date('Y-m-d', strtotime('-7 days'));
     //$days_ago = date('Y-m-d', strtotime('-7 days'));
    //$end_date = date('Y-m-d');
   // $end_date = date('Y-m-d');
   //$start_date = date('Y-m-01'); // Returns the 1st day of the current month
    //$end_date   = date('Y-m-t');  // Returns the last day of the current month

    $start_date = $this->input->get('start_date');
    $end_date = $this->input->get('end_date');
    $status = $this->input->get('order_status');

    if (empty($status)) {
        $status = 'all';
    }

    $data = array(

        'active'   => 'reports',
        'title'    => 'Sales Report',
        'subtitle' => 'Sales performance view designed for ecommerce reporting and Excel export.',

       // 'kpis' => $this->Order_model->get_by_kpis($today, $status),
       'kpi' => $this->Order_model->get_by_kpis($start_date,$end_date, $status),

        
       // 'sales_rows' => $this->Order_model->get_sales_report_by_today($today, $status),

       'sales_rows' => $this->Order_model->get_sales_report_by_custom_date_range($start_date,$end_date, $status),


        'selected_status' => $status
      //  'selected_dates'=> $start_date .' to '. $end_date
    );

    $this->render('reports', $data);
}
*/
    public function settings()
    {
        $data = array(
            'active' => 'settings',
            'title' => 'Settings',
            'subtitle' => 'Store profile, tax, shipping and notification controls.',
            'table_title' => 'Saved Configuration',
            'headers' => array('Setting', 'Group', 'Value', 'Updated On'),
            'rows' => array(
                array('Store Name', 'General', 'PackMart Wholesale', '05 Mar 2026'),
                array('Default Tax', 'Finance', '18%', '05 Mar 2026'),
                array('Low Stock Threshold', 'Inventory', '150', '05 Mar 2026'),
                array('COD Orders', 'Checkout', 'Enabled', '05 Mar 2026')
            )
        );

        $this->render('master_table', $data);
    }

    public function login()
    {
        $this->load->view('admin/pages/login');
    }

    private function render($view, $data = array())
    {
        $data['nav_items'] = $this->nav;
        $this->load->view('admin/partials/header', $data);
        $this->load->view('admin/partials/sidebar', $data);
        $this->load->view('admin/pages/' . $view, $data);
        $this->load->view('admin/partials/footer', $data);
    }
}


/*
encountered
Severity: Warning

Message: Undefined array key "gst"

Filename: controllers/Admin.php

Line Number: 1209

Backtrace:

File: C:\xampp_new\htdocs\pollmarket\application\controllers\Admin.php
Line: 1209
Function: _error_handler

File: C:\xampp_new\htdocs\pollmarket\index.php
Line: 326
Function: require_once

A PHP Error was encountered
Severity: Warning

Message: Undefined array key "taxable"

Filename: controllers/Admin.php

Line Number: 1213

Backtrace:

File: C:\xampp_new\htdocs\pollmarket\application\controllers\Admin.php
Line: 1213
Function: _error_handler

File: C:\xampp_new\htdocs\pollmarket\index.php
Line: 326
Function: require_once

*/