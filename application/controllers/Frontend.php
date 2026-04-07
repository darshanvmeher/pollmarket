<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Products_model');
    }

    private function nav_items()
    {
        return array(
            array('label' => 'Home', 'url' => 'frontend'),
            array('label' => 'Shop', 'url' => 'frontend/shop'),
            array('label' => 'Categories', 'url' => 'frontend/categories'),
            array('label' => 'Offers', 'url' => 'frontend/offers'),
            array('label' => 'About', 'url' => 'frontend/about'),
            array('label' => 'Contact', 'url' => 'frontend/contact')
        );
    }

   /* private function product_catalog()
    {
        return array(
            array('name' => 'Heavy Duty Garbage Bags', 'category' => 'Plastic Bags', 'price' => '₹349', 'old_price' => '₹399', 'badge' => 'Best Seller', 'rating' => '4.8', 'image' => 'garbage-bag', 'image_url' => base_url('assets/frontend/images/products/garbage-bag.png')),
            array('name' => 'A4 Copier Paper Bundle', 'category' => 'Stationery', 'price' => '₹499', 'old_price' => '₹599', 'badge' => 'Top Rated', 'rating' => '4.9', 'image' => 'stationery', 'image_url' => base_url('assets/frontend/images/products/stationery.jpg')),
            array('name' => 'Silver Foil Sheet Roll', 'category' => 'Silver Foil', 'price' => '₹799', 'old_price' => '₹949', 'badge' => 'New', 'rating' => '4.7', 'image' => 'silver-foil', 'image_url' => base_url('assets/frontend/images/products/silver-foil.jpg')),
            array('name' => 'RFID Tamper Seal Pack', 'category' => 'RFID Seals', 'price' => '₹1,999', 'old_price' => '₹2,499', 'badge' => 'Bulk', 'rating' => '4.6', 'image' => 'rfid-seal', 'image_url' => base_url('assets/frontend/images/products/rfid-seal.jpg')),
            array('name' => 'Paper Carry Bag Medium', 'category' => 'Paper Bags', 'price' => '₹429', 'old_price' => '₹499', 'badge' => 'Eco', 'rating' => '4.8', 'image' => 'paper-bag', 'image_url' => base_url('assets/frontend/images/products/paper-bag.jpg')),
            array('name' => 'Cling Film Roll', 'category' => 'Cling Films', 'price' => '₹579', 'old_price' => '₹699', 'badge' => 'New', 'rating' => '4.7', 'image' => 'cling-film', 'image_url' => base_url('assets/frontend/images/products/cling-film.jpg')),
            array('name' => 'Office Stationery Kit', 'category' => 'Stationery', 'price' => '₹1,499', 'old_price' => '₹1,799', 'badge' => 'Combo', 'rating' => '4.9', 'image' => 'kit', 'image_url' => base_url('assets/frontend/images/products/stationery.jpg'))
        );
    }*/

   /*private function find_product($slug)
    {
        foreach ($this->product_catalog() as $product) {
            if ($product['image'] === $slug) {
                return $product;
            }
        }

        return $this->product_catalog()[0];
    }*/
    public function product($id)
{
    $this->load->model('Products_model');

    // ✅ GET PRODUCT FROM DB
    $product = $this->Products_model->get_product_by_id($id);

    if (!$product) {
        show_404();
    }

    // ✅ ADD MEDIA TO MAIN PRODUCT
    $product['media'] = $this->Products_model->get_product_media($id);

    // ✅ SAFE DEFAULT VALUES
   // $product['category_name'] = $product['category_name'] ?? 'Category';
    //$product['badge'] = $product['badge'] ?? 'New';
    //$product['rating'] = $product['rating'] ?? '4.5';

    // ✅ GET ALL PRODUCTS
    $all_products = $this->Products_model->get_product_list();

    // ✅ ADD MEDIA TO EACH PRODUCT
    foreach ($all_products as &$p) {
        $p['media'] = $this->Products_model->get_product_media($p['id']);
    }

    // ✅ FILTER RELATED PRODUCTS
    $related_products = array_values(array_filter($all_products, function($p) use ($id) {
        return $p['id'] != $id;
    }));

    // ✅ RANDOM + LIMIT
    shuffle($related_products);
    $related_products = array_slice($related_products, 0, 4);

    // ✅ PASS DATA TO VIEW
    $data = [
        'title' => 'Product Details',
        'nav_items' => $this->nav_items(),
        'product' => $product,
        'related_products' => $related_products
    ];

    $this->load->view('frontend/pages/product', $data);
}

    public function index()
    {
        $products = $this->Products_model->get_product_list();

        shuffle($products); // ✅ RANDOM EACH TIME


        $data = array(
            'title' => 'Home',
            'nav_items' => $this->nav_items(),
            'hero' => array(
                'title' => 'Packaging essentials for Indian businesses.',
                'subtitle' => 'Garbage bags, paper bags, cling films, foil, and more.'
            ),
            'hero_scene' => array(
                'warehouse' => base_url('assets/frontend/images/products/indian-warehouse.jpg'),
                'office' => base_url('assets/frontend/images/products/indian-office-team.jpg')
            ),
            'featured_categories' => array(
                array('label' => 'Plastic Garbage Bags', 'count' => '120+ SKUs'),
                array('label' => 'Stationery Materials', 'count' => '90+ SKUs'),
                array('label' => 'Silver Foil Papers', 'count' => '40+ SKUs'),
                array('label' => 'RFID Seals', 'count' => '25+ SKUs')
            ),
            /*'hero_products' => array(
                $this->product_catalog()[0],
                $this->product_catalog()[4],
                $this->product_catalog()[5]
            ),*/
            'hero_products' => array_slice($products, 0, 3),
            //  'featured_products' => array_slice($this->product_catalog(), 0, 4),
            'featured_products' => array_slice($products, 0, 4),


            'clients' => array(
                array('name' => 'Retail Mart Pvt. Ltd.', 'segment' => 'Wholesale retail chain', 'monthly' => '₹12.4L', 'status' => 'Active'),
                array('name' => 'Shakti Traders', 'segment' => 'Reseller network', 'monthly' => '₹8.9L', 'status' => 'Active'),
                array('name' => 'Prime Supplies', 'segment' => 'Corporate procurement', 'monthly' => '₹4.3L', 'status' => 'Priority'),
                array('name' => 'Westline Stores', 'segment' => 'Neighborhood retail', 'monthly' => '₹1.9L', 'status' => 'Growing')
            ),
            'use_cases' => array(
                array('title' => 'Warehouse Packaging', 'text' => 'Garbage bags, RFID seals, and bulk-ready supplies for logistics teams across India.'),
                array('title' => 'Retail Counter Stock', 'text' => 'Paper bags, stationery, and fast-moving essentials for daily sell-through.'),
                array('title' => 'Food Service', 'text' => 'Silver foil rolls and hygienic packaging products for kitchens and caterers.'),
                array('title' => 'Office Procurement', 'text' => 'Stationery bundles and office supplies for recurring corporate orders.')
            ),
            'client_logos' => array(
                array('name' => 'Retail Mart', 'tag' => 'Wholesale Chain'),
                array('name' => 'Prime Supplies', 'tag' => 'Corporate Procurement'),
                array('name' => 'Nova Retail', 'tag' => 'Multi-Store'),
                array('name' => 'Shakti Traders', 'tag' => 'Distributor'),
                array('name' => 'Westline Stores', 'tag' => 'Retail Group'),
                array('name' => 'Metro Pack', 'tag' => 'Bulk Buyer')
            ),
            'industries' => array(
                array('title' => 'Retail & FMCG', 'copy' => 'Paper bags, garbage bags, and checkout essentials for high-turnover storefronts.', 'accent' => '0'),
                array('title' => 'Warehousing', 'copy' => 'RFID seals and heavy-duty packaging for inventory control and shipping.', 'accent' => '1'),
                array('title' => 'Food Service', 'copy' => 'Silver foil papers and hygienic supplies for kitchens and catering teams.', 'accent' => '2'),
                array('title' => 'Office Supply', 'copy' => 'Stationery bundles, paper products, and recurring replenishment programs.', 'accent' => '3')
            ),
            'testimonials' => array(
                array('name' => 'Retail Mart', 'text' => 'Reliable bulk pricing and quick restocking for packaging items.'),
                array('name' => 'Shakti Traders', 'text' => 'The storefront makes repeat ordering simple for our team.'),
                array('name' => 'Prime Supplies', 'text' => 'Clean design, easy navigation, and strong product presentation.')
            ),
            'sustainability' => array(
                array('title' => 'Reliable sourcing', 'copy' => 'Clear product categories and consistent wholesale-ready supply.'),
                array('title' => 'India-focused operations', 'copy' => 'Built for GST billing, business accounts, and pan-India ordering.'),
                array('title' => 'Modern presentation', 'copy' => 'A premium storefront that helps buyers browse faster and convert sooner.')
            ),
            'certifications' => array(
                array('title' => 'Quality assured', 'copy' => 'Product cards and brand cues designed to build trust at first glance.'),
                array('title' => 'Bulk order ready', 'copy' => 'Structured for repeat procurement and large-volume buying.'),
                array('title' => 'Fast dispatch', 'copy' => 'Optimized for quick inquiry flow and order movement.')
            )
        );

        $this->load->view('frontend/pages/home', $data);
    }

    public function shop()
    {
        $data = array(
            'title' => 'Shop',
            'nav_items' => $this->nav_items(),
            'products' => $this->product_catalog(),
            'categories' => array('All', 'Plastic Bags', 'Stationery', 'Silver Foil', 'RFID Seals', 'Paper Bags')
        );

        $this->load->view('frontend/pages/shop', $data);
    }

    /*public function product($id')
    {   
         $this->load->model('Products_model');

         $catalog = $this->Products_model->get_product_list();

        $selected = $this->find_product($slug);
        $gallery_map = array(
            'garbage-bag' => array(
                base_url('assets/frontend/images/products/garbage-bag.png'),
                base_url('assets/frontend/images/products/garbage-bag.jpg'),
                base_url('assets/frontend/images/products/indian-warehouse.jpg'),
                base_url('assets/frontend/images/products/paper-bag.jpg')
            ),
            'paper-bag' => array(
                base_url('assets/frontend/images/products/paper-bag.jpg'),
                base_url('assets/frontend/images/products/indian-office-team.jpg'),
                base_url('assets/frontend/images/products/garbage-bag.png'),
                base_url('assets/frontend/images/products/cling-film.jpg')
            ),
            'cling-film' => array(
                base_url('assets/frontend/images/products/cling-film.jpg'),
                base_url('assets/frontend/images/products/indian-warehouse.jpg'),
                base_url('assets/frontend/images/products/paper-bag.jpg'),
                base_url('assets/frontend/images/products/silver-foil.jpg')
            ),
            'silver-foil' => array(
                base_url('assets/frontend/images/products/silver-foil.jpg'),
                base_url('assets/frontend/images/products/indian-warehouse.jpg'),
                base_url('assets/frontend/images/products/cling-film.jpg'),
                base_url('assets/frontend/images/products/rfid-seal.jpg')
            ),
            'rfid-seal' => array(
                base_url('assets/frontend/images/products/rfid-seal.jpg'),
                base_url('assets/frontend/images/products/indian-office-team.jpg'),
                base_url('assets/frontend/images/products/indian-warehouse.jpg'),
                base_url('assets/frontend/images/products/garbage-bag.png')
            ),
            'stationery' => array(
                base_url('assets/frontend/images/products/stationery.jpg'),
                base_url('assets/frontend/images/products/indian-office-team.jpg'),
                base_url('assets/frontend/images/products/paper-bag.jpg'),
                base_url('assets/frontend/images/products/garbage-bag.png')
            )
        );
        $gallery = isset($gallery_map[$selected['image']]) ? $gallery_map[$selected['image']] : array($selected['image_url']);
        $data = array(
            'title' => 'Product Details',
            'nav_items' => $this->nav_items(),
            'slug' => $slug,
            'product' => array_merge($selected, array(
                'stock' => 'In stock',
                'description' => 'Durable, commercial-grade packaging built for Indian business operations.',
                'gallery' => $gallery
            )),
            'related_products' => array_values(array_filter($catalog, function ($item) use ($selected) {
                return $item['image'] !== $selected['image'];
            }))
        );

        $this->load->view('frontend/pages/product', $data);
    }*/

    public function cart()
    {
        $catalog = $this->product_catalog();
        $data = array(
            'title' => 'Cart',
            'nav_items' => $this->nav_items(),
            'items' => array(
                array('name' => 'Heavy Duty Garbage Bags', 'category' => 'Plastic Bags', 'qty' => 2, 'price' => '₹349', 'subtotal' => '₹698', 'image_url' => $catalog[0]['image_url']),
                array('name' => 'RFID Tamper Seal Pack', 'category' => 'RFID Seals', 'qty' => 1, 'price' => '₹1,999', 'subtotal' => '₹1,999', 'image_url' => $catalog[3]['image_url'])
            )
        );

        $this->load->view('frontend/pages/cart', $data);
    }

    public function checkout()
    {
        $data = array(
            'title' => 'Checkout',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/checkout', $data);
    }
    public function wishlist()
    {
    // Load model first
        $this->load->model('Products_model');

        $data = array(
            'title' => 'Wishlist',
            'nav_items' => $this->nav_items(),
            'items' => array_slice($this->Products_model->get_product_list(), 0, 3),
        );

        $this->load->view('frontend/pages/wishlist', $data);
    }

    public function account()
    {
        $data = array(
            'title' => 'My Account',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/account', $data);
    }

    public function login()
    {
        $data = array(
            'title' => 'Login',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/login', $data);
    }

    public function register()
    {
        $data = array(
            'title' => 'Register',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/register', $data);
    }

    public function about()
    {
        $data = array(
            'title' => 'About',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/about', $data);
    }

    public function contact()
    {
        $data = array(
            'title' => 'Contact',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/contact', $data);
    }

    public function offers()
    {
        $data = array(
            'title' => 'Offers',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/offers', $data);
    }

    public function categories()
    {
        $data = array(
            'title' => 'Categories',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/categories', $data);
    }

    public function track_order()
    {
        $data = array(
            'title' => 'Track Order',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/track_order', $data);
    }

    public function faq()
    {
        $data = array(
            'title' => 'FAQ',
            'nav_items' => $this->nav_items()
        );

        $this->load->view('frontend/pages/faq', $data);
    }

    public function bulk_buyers()
    {
        $data = array(
            'title' => 'Bulk Buyers',
            'nav_items' => $this->nav_items(),
            'hero_products' => array_slice($this->product_catalog(), 0, 3),
            'hero' => array(
                'title' => 'Bulk pricing, reliable supply, and faster reordering for Indian businesses',
                'subtitle' => 'A dedicated procurement landing page for wholesalers, distributors, retail chains, and GST-registered business accounts that buy in volume.'
            ),
            'benefits' => array(
                array('title' => 'Custom pricing', 'copy' => 'Tiered rates for recurring volume buyers and category-specific purchasing.'),
                array('title' => 'Priority dispatch', 'copy' => 'Repeat and scheduled orders fulfilled with faster dispatch planning.'),
                array('title' => 'GST invoicing', 'copy' => 'Business-ready billing support for Indian procurement teams.')
            ),
            'cta_stats' => array(
                array('label' => 'Procurement clients', 'value' => '250+'),
                array('label' => 'Average order size', 'value' => '₹1.8L'),
                array('label' => 'Repeat rate', 'value' => '68%')
            ),
            'bulk_steps' => array(
                array('title' => 'Share your requirement', 'copy' => 'Send quantity, category mix, and delivery location.'),
                array('title' => 'Receive a quote', 'copy' => 'We return pricing, billing terms, and dispatch timeline.'),
                array('title' => 'Confirm supply', 'copy' => 'Approve once, then reorder with less friction next time.')
            ),
            'bulk_bundles' => array(
                array('title' => 'Garbage bag supply', 'copy' => 'High-volume waste bag packs for facilities and retail chains.', 'image' => base_url('assets/frontend/images/products/garbage-bag.png')),
                array('title' => 'Paper bag orders', 'copy' => 'Kraft and carry bag procurement for counters and stores.', 'image' => base_url('assets/frontend/images/products/paper-bag.jpg')),
                array('title' => 'Food service packs', 'copy' => 'Silver foil and cling film bundles for kitchens and caterers.', 'image' => base_url('assets/frontend/images/products/silver-foil.jpg')),
                array('title' => 'Office essentials', 'copy' => 'Stationery kits for procurement teams and branch offices.', 'image' => base_url('assets/frontend/images/products/stationery.jpg'))
            ),
            'trust_points' => array(
                array('title' => 'Transparent quotes', 'copy' => 'Pricing built for budget planning and bulk comparison.'),
                array('title' => 'Account support', 'copy' => 'Direct support for recurring orders and quick follow-ups.'),
                array('title' => 'Pan-India delivery', 'copy' => 'Supply movement aligned with your distribution needs.'),
                array('title' => 'Category depth', 'copy' => 'Packaging, stationery, foil, and RFID in one catalog.')
            ),
            'client_logos' => array(
                array('name' => 'Retail Mart', 'tag' => 'Wholesale Chain'),
                array('name' => 'Prime Supplies', 'tag' => 'Corporate'),
                array('name' => 'Nova Retail', 'tag' => 'Retail Group'),
                array('name' => 'Shakti Traders', 'tag' => 'Distributor')
            )
        );

        $this->load->view('frontend/pages/bulk_buyers', $data);
    }
}
