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
        'orders' => array('label' => 'Orders', 'icon' => 'bi bi-receipt', 'url' => 'admin/orders'),
        'customers' => array('label' => 'Customers', 'icon' => 'bi bi-people', 'url' => 'admin/customers'),
        'inventory' => array('label' => 'Inventory', 'icon' => 'bi bi-boxes', 'url' => 'admin/inventory'),
        'suppliers' => array('label' => 'Suppliers', 'icon' => 'bi bi-truck', 'url' => 'admin/suppliers'),
        'promotions' => array('label' => 'Promotions', 'icon' => 'bi bi-megaphone', 'url' => 'admin/promotions'),
        'reports' => array('label' => 'Reports', 'icon' => 'bi bi-bar-chart', 'url' => 'admin/reports'),
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

    public function products()
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
        $data = array(
            'active' => 'orders',
            'title' => 'Orders',
            'subtitle' => 'Track fulfillment, shipping, and returns.',
            'table_title' => 'Saved Orders',
            'headers' => array('Order', 'Customer', 'Amount', 'Items', 'Status', 'Date'),
            'rows' => array(
                array('#PM-2901', 'Retail Mart Pvt.', '$214.00', '16', 'Shipped', '05 Mar 2026'),
                array('#PM-2896', 'Shakti Traders', '$89.40', '8', 'Packed', '05 Mar 2026'),
                array('#PM-2888', 'Prime Supplies', '$420.10', '34', 'Delivered', '04 Mar 2026'),
                array('#PM-2879', 'Westline Stores', '$63.50', '5', 'Payment Failed', '04 Mar 2026')
            )
        );

        $this->render('master_table', $data);
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
       'title' => 'subcategories',
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
        $data = array(
            'active' => 'promotions',
            'title' => 'Promotions',
            'subtitle' => 'Manage discount coupons and bulk offers.',
            'table_title' => 'Saved Promotions',
            'headers' => array('Code', 'Type', 'Discount', 'Validity', 'Usage', 'Status'),
            'rows' => array(
                array('BULK5', 'Order Value', '5%', 'Mar 01 - Mar 31', '128', 'Active'),
                array('RFID10', 'Category', '10%', 'Mar 05 - Mar 15', '14', 'Active'),
                array('WELCOME15', 'First Order', '15%', 'Feb 01 - Apr 01', '230', 'Active'),
                array('FOILFEST', 'Product', '$3 off', 'Mar 10 - Mar 20', '0', 'Scheduled')
            )
        );

        $this->render('master_table', $data);
    }

    public function reports()
    {
        $data = array(
            'active' => 'reports',
            'title' => 'Reports',
            'subtitle' => 'Sales, category and stock performance snapshots.',
            'table_title' => 'Saved Report Snapshots',
            'headers' => array('Period', 'Revenue', 'Orders', 'Return Rate', 'Top Category'),
            'rows' => array(
                array('Jan 2026', '$42,300', '970', '2.1%', 'Plastic Bags'),
                array('Feb 2026', '$48,880', '1,108', '1.8%', 'Plastic Bags'),
                array('Mar 2026 (MTD)', '$58,020', '1,284', '1.9%', 'Stationery')
            )
        );

        $this->render('master_table', $data);
    }

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
