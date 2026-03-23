<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Mpdf\Mpdf;

class Api_handler extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Admin_model');
        $this->load->model('Category_model');
        $this->load->model('Sub_category_model');
        $this->load->model('Products_model');
        $this->load->model('Order_model');
        $this->load->model('Attribute_model');

        
    }





    public function generate_token()
    {
        $key = "this_is_my_super_secret_key_for_jwt_token_12345";

        $payload = [
            "user_id" => 1,
            "email" => "test@gmail.com",
            "iat" => time(),
            "exp" => time() + 3600
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        echo $jwt;
    }

    public function generate_pdf()
    {
        try {

            $mpdf = new \Mpdf\Mpdf();

            $html = "<h1>Hello PDF</h1>";
            $mpdf->WriteHTML($html);

            $mpdf->Output();

        } catch (\Exception $e) {

            echo $e->getMessage();

        }
    }


    //admin module

    //admin login
 public function admin_login()
{
    $email = $this->input->post('email');
    $phone_no = $this->input->post('phone_no');
    $password = $this->input->post('password');

    if (empty($email) || empty($phone_no) || empty($password)) {
        echo json_encode([
            'status' => false,
            'message' => 'All fields are required'
        ]);
        return;
    }

    // Check email
    $admin = $this->Admin_model->get_admin_by_email($email);

    if (!$admin) {
        echo json_encode([
            'status' => false,
            'message' => 'Incorrect email'
        ]);
        return;
    }

    // Check phone number
   
    $phone = $this->Admin_model->check_admin_phone($email, $phone_no);

    if (!$phone) {
        echo json_encode([
            'status' => false,
            'message' => 'Incorrect phone number'
        ]);
        return;
    }

    // Check password
    if (!password_verify($password, $admin['password'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Incorrect password'
        ]);
        return;
    }

    // Generate JWT token
    $key = "this_is_my_super_secret_key_for_jwt_token_12345";

    $payload = [
        'admin_id' => $admin['id'],
        'email' => $admin['email'],
        'phone_no' => $admin['phone_no'],
        'iat' => time(),
        'exp' => time() + 3600
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');

    echo json_encode([
        "status" => true,
        "message" => "Login successful",
        "token" => $jwt
    ]);
}
//verfy token

/*private function verify_token()
{
    $headers = $this->input->request_headers();

    if (!isset($headers['Authorization'])) {
        echo json_encode([
            "status" => false,
            "message" => "Token required"
        ]);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);


    $key = "this_is_my_super_secret_key_for_jwt_token_12345";

    try {

        $decoded = JWT::decode($token, new Key($key, 'HS256'));

        return $decoded;

    } catch (Exception $e) {

        echo json_encode([
            "status" => false,
            "message" => "Invalid Token"
        ]);
        exit;

    }
}*/

private function verify_token()
{
    $headers = $this->input->request_headers();

    if (!isset($headers['Authorization'])) {
        echo json_encode([
            "status" => false,
            "message" => "Token required"
        ]);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);

    $key = "this_is_my_super_secret_key_for_jwt_token_12345";

    try {

        $decoded = JWT::decode($token, new Key($key, 'HS256'));
        return $decoded;

    } catch (\Firebase\JWT\ExpiredException $e) {

        echo json_encode([
            "status" => false,
            "message" => "Token expired"
        ]);
        exit;

    } catch (Exception $e) {

        echo json_encode([
            "status" => false,
            "message" => "Invalid token"
        ]);
        exit;
    }
}

//catgory api

//add category
public function add_category()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;


    $category_name = $this->input->post('category_name');
    $description   = $this->input->post('description');
    $status        = $this->input->post('status') ?? '1';

    if (empty($category_name)) {
        echo json_encode([
            "status" => false,
            "message" => "Category name required"
        ]);
        return;
    }

    $data = [
        "category_name" => $category_name,
        "description"   => $description,
        "status"        => $status
    ];

    $insert = $this->Category_model->insert_category($data);

    if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "Category added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to add category"
        ]);
    }
}

//update category
public function update_category()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    $category = $this->Category_model->get_category_by_id($id);

    if (!$category) {
        echo json_encode([
            'status'=>false,
            'message'=>'Category not found or deleted'
        ]);
        return;
    }

    if ($category['id'] != $id) {
        echo json_encode([
            'status'=>false,
            'message'=>'You are not allowed to update this category'
        ]);
        return;
    }


    $data = [
        "category_name" => $this->input->post('category_name'),
        "description" => $this->input->post('description'),
        "updated_at" => date("Y-m-d H:i:s")
    ];

    $update = $this->Category_model->update_category($id, $data);



    echo json_encode([
        "status" => $update,
        "message" => $update ? "Category updated" : "Update failed"
    ]);
}

//delete category

public function delete_category()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;  

    
    $id = $this->input->post('id');

    $category = $this->Category_model->get_category_by_id($id);

    if (!$category) {
        echo json_encode([
            'status'=>false,
            'message'=>'Category ID not found or deleted'
        ]);
        return;
    }

   /* if ($category['id'] != $id) {
        echo json_encode([
            'status'=>false,
            'message'=>'You are not allowed to delete this category'
        ]);
        return;
    }*/
    $delete = $this->Category_model->soft_delete_category($id);

    echo json_encode([
        "status" => $delete,
        "message" => "Category deleted"
    ]);
}

//list category

public function list_categories()
{
   $decoded = $this->verify_token();
   $admin_id = $decoded->admin_id;

    $categories = $this->Category_model->get_categories();

    echo json_encode([
        "status" => true,
        "data" => $categories
    ]);
}

//subcategory api

//add subcategory

public function add_subcategory()
{
$decoded = $this->verify_token();
$admin_id = $decoded->admin_id;
   
    $category_id = $this->input->post('category_id');
    $sub_category_name = $this->input->post('sub_category_name');
    $description = $this->input->post('description');
    $status = $this->input->post('status') ?? '1';


    if (empty($category_id) || empty($sub_category_name)) {
        echo json_encode([
            "status" => false,
            "message" => "Category and Sub Category name required"
        ]);
        return;
    }

    $data = [
        "category_id" => $category_id,
        "sub_category_name" => $sub_category_name,
        "description" => $description,
        "status" => $status
    ];

    $category = $this->Category_model->get_category_by_id($category_id);

if (!$category) {
    echo json_encode([
        "status" => false,
        "message" => "Category not found"
    ]);
    return;
}

    $insert = $this->Sub_category_model->insert_sub_category($data);

    echo json_encode([
        "status" => $insert ? true : false,
        "message" => $insert ? "Sub category added" : "Insert failed"
    ]);


    }

//update subcategory

public function update_sub_category()
{
    $decoded = $this->verify_token();
$admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    $sub_category = $this->Sub_category_model->get_sub_category_by_id($id);

    if (!$sub_category) {
        echo json_encode([
            'status'=>false,
            'message'=>'Sub Category ID not found or deleted'
        ]);
        return;
    }

    // get category id from request
    $category_id = $this->input->post('category_id');

    // check category exists
    $category = $this->Category_model->get_category_by_id($category_id);

    if (!$category) {
        echo json_encode([
            'status'=>false,
            'message'=>'Category not found'
        ]);
        return;
    }

    $data = [
        "category_id" => $category_id,
        "sub_category_name" => $this->input->post('sub_category_name'),
        "description" => $this->input->post('description'),
        "updated_at" => date("Y-m-d H:i:s")
    ];

    $update = $this->Sub_category_model->update_sub_category($id,$data);

    echo json_encode([
        "status" => $update ? true : false,
        "message" => $update ? "Sub category updated" : "Update failed"
    ]);
}

//delete subcategory

public function delete_sub_category()
{
    $decoded = $this->verify_token();
$admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    
    $sub_category = $this->Sub_category_model->get_sub_category_by_id($id);

    if (!$sub_category) {
        echo json_encode([
            'status'=>false,
            'message'=>'Sub Category ID not found or deleted'
        ]);
        return;
    }


    $delete = $this->Sub_category_model->soft_delete_sub_category($id);

    echo json_encode([
        "status" => $delete ? true : false,
        "message" => $delete ? "Sub category deleted" : "Delete failed"
    ]);
}


//list subcategory

public function list_sub_categories()
{
    $decoded = $this->verify_token();
$admin_id = $decoded->admin_id;

    $data = $this->Sub_category_model->get_sub_categories();

    echo json_encode([
        "status" => true,
        "data" => $data
    ]);
}


//product api

//add product
/*
public function add_product()
{
  $decoded = $this->verify_token();
   $admin_id = $decoded->admin_id;

     $sub_category_id = $this->input->post('sub_category_id');
    $product_name = $this->input->post('product_name');
    $attribute_id = $this->input->post('attribute_id');
    $price = $this->input->post('price');
    $description = $this->input->post('description');
    $stock = $this->input->post('stock');
    $status = $this->input->post('status') ?? '1';

    if (empty($sub_category_id) || empty($product_name) || empty($price) || empty($stock)|| empty($attribute_id) ){
        echo json_encode([
            "status" => false,
            "message" => "Required fields are missing"
        ]);
        return;


    }

    $data = [
        "sub_category_id" => $sub_category_id,
        "product_name" => $product_name,
        "attribute_id" => $attribute_id,
        "price" => $price,
        "description" => $description,
        "stock" => $stock,
        "status" => $status
    ];

    $sub_category = $this->Sub_category_model->get_sub_category_by_id($sub_category_id);
    if(!$sub_category){
        echo json_encode([
            "status" => false,
            "message" => "Sub category not found"
        ]);
        return;
    }
    $insert = $this->Products_model->insert_product($data);

    echo json_encode([
        "status" => $insert ? true : false,
        "message" => $insert ? "Product added" : "Insert failed"
    ]);

}*/


public function add_product()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $sub_category_id = $this->input->post('sub_category_id');
    $product_name = $this->input->post('product_name');
    $price = $this->input->post('price');
    $description = $this->input->post('description');
    $stock = $this->input->post('stock');
    $status = $this->input->post('status') ?? '1';

    if (empty($sub_category_id) || empty($product_name) || empty($price) || empty($stock) ) {
        echo json_encode([
            "status" => false,
            "message" => "Required fields are missing"
        ]);
        return;
    }

    $data = [
        "sub_category_id" => $sub_category_id,
        "product_name" => $product_name,
        "price" => $price,
        "description" => $description,
        "stock" => $stock,
        "status" => $status
    ];

    $sub_category = $this->Sub_category_model->get_sub_category_by_id($sub_category_id);

    if (!$sub_category) {
        echo json_encode([
            "status" => false,
            "message" => "Sub category not found"
        ]);
        return;
    }

    // INSERT PRODUCT
    $insert = $this->Products_model->insert_product($data);

    if(!$insert){
        echo json_encode([
            "status" => false,
            "message" => "Insert failed"
        ]);
        return;
    }

    // GET PRODUCT ID
    $product_id = $this->db->insert_id();

    //add attribute

    $attributes = $this->input->post('attributes');

if (!empty($attributes)) {
    foreach ($attributes as $attr) {

        $attr_data = [
            "product_id" => $product_id,
            "attribute_id" => $attr['attribute_id'],
            "value" => $attr['value'],
        ];

$this->Products_model->insert_product_attribute($attr_data);    }
}

    // MEDIA UPLOAD

    if(!empty($_FILES['media']['name'][0]))
    {
        $upload_path = 'uploads/products/';

        if(!is_dir($upload_path)){
            mkdir($upload_path,0777,true);
        }

        $files = $_FILES['media'];
        $count = count($files['name']);

        for($i=0;$i<$count;$i++)
        {
            $_FILES['file']['name'] = $files['name'][$i];
            $_FILES['file']['type'] = $files['type'][$i];
            $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['file']['error'] = $files['error'][$i];
            $_FILES['file']['size'] = $files['size'][$i];

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|mp4|mov|avi';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if($this->upload->do_upload('file'))
            {
                $uploadData = $this->upload->data();

                $type = "photos";

                if(in_array($uploadData['file_ext'], ['.mp4','.mov','.avi'])){
                    $type = "videos";
                }

                $media_data = [
                    "product_id" => $product_id,
                    "media_types" => $type,
                    "media_path" => $upload_path.$uploadData['file_name'],
                    "status" => 1
                ];

                $this->db->insert("product_media_tbl", $media_data);
            }
        }
    }

    echo json_encode([
        "status" => true,
        "message" => "Product added with media"
    ]);
}

//update product
/*
public function update_product()
{
    $decoded = $this->verify_token();
   $admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    $product = $this->Products_model->get_product_by_id($id);

    if (!$product) {
        echo json_encode([
            'status'=>false,
            'message'=>'Product ID not found or deleted'
        ]);
        return;
    }

    // get sub category id from request
    $sub_category_id = $this->input->post('sub_category_id');
    // check sub category exists
    $sub_category = $this->Sub_category_model->get_sub_category_by_id($sub_category_id);

    if (!$sub_category) {
        echo json_encode([
            'status'=>false,
            'message'=>'Sub category not found'
        ]);
        return;
    }   

    $data = [
        "sub_category_id" => $sub_category_id,
        "product_name" => $this->input->post('product_name'),
        "attribute_id" => $this->input->post('attribute_id'),
        "price" => $this->input->post('price'),
        "description" => $this->input->post('description'),
        "stock" => $this->input->post('stock')
    ];
 
    $update=$this->Products_model->update_product($id,$data);

      echo json_encode([
        "status" => $update ? true : false,
        "message" => $update ? "Product updated" : "Update failed"
    ]);

}*/


public function update_product()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    $product = $this->Products_model->get_product_by_id($id);

    if (!$product) {
        echo json_encode([
            'status'=>false,
            'message'=>'Product ID not found or deleted'
        ]);
        return;
    }

    $sub_category_id = $this->input->post('sub_category_id');

    $sub_category = $this->Sub_category_model->get_sub_category_by_id($sub_category_id);

    if (!$sub_category) {
        echo json_encode([
            'status'=>false,
            'message'=>'Sub category not found'
        ]);
        return;
    }

    $data = [
        "sub_category_id" => $sub_category_id,
        "product_name" => $this->input->post('product_name'),
        "price" => $this->input->post('price'),
        "description" => $this->input->post('description'),
        "stock" => $this->input->post('stock')
    ];

    $update = $this->Products_model->update_product($id,$data);

    $attributes = $this->input->post('attributes');

if (!empty($attributes)) {
    foreach ($attributes as $attr) {

        if (!empty($attr['attribute_id']) && !empty($attr['value'])) {

            $attr_data = [
                "product_id" => $id,
                "attribute_id" => $attr['attribute_id'],
                "value" => $attr['value'],
            ];

            $this->Products_model->upsert_product_attribute($attr_data);
        }
    }
}

    // -------- MULTIPLE MEDIA UPLOAD --------

    if (!empty($_FILES['media']['name'][0])) {

        $upload_path = 'uploads/products/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path,0777,true);
        }

        $files = $_FILES['media'];
        $count = count($files['name']);

        for ($i=0; $i<$count; $i++) {

            $_FILES['file']['name'] = $files['name'][$i];
            $_FILES['file']['type'] = $files['type'][$i];
            $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['file']['error'] = $files['error'][$i];
            $_FILES['file']['size'] = $files['size'][$i];

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|webp|mp4|mov|avi';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file')) {

                $uploadData = $this->upload->data();

                // detect media type
                $media_type = 'photos';

                if (in_array($uploadData['file_ext'], ['.mp4','.mov','.avi'])) {
                    $media_type = 'videos';
                }

                $media_data = [
                    "product_id" => $id,
                    "media_types" => $media_type,
                    "media_path" => $upload_path.$uploadData['file_name'],
                    "status" => 1
                ];

                $this->db->insert('product_media_tbl', $media_data);
            }
        }
    }

    echo json_encode([
        "status" => $update ? true : false,
        "message" => $update ? "Product updated successfully" : "Update failed"
    ]);
}

//delete

public function delete_product()
{
      $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    
    $product = $this->Products_model->get_product_by_id($id);

    if (!$product) {
        echo json_encode([
            'status'=>false,
            'message'=>'Product ID not found or deleted'
        ]);
        return;
    }


    $delete = $this->Products_model->soft_delete_product($id);

    echo json_encode([
        "status" => $delete ? true : false,
        "message" => $delete ? "Product deleted" : "Delete failed"
    ]);
}


//list_products


public function list_products()
{
    $decoded = $this->verify_token();
$admin_id = $decoded->admin_id;

    $data = $this->Products_model->get_product_list();

    if (!empty($data)) {
        echo json_encode([
            "status" => true,
            "message" => "Product list fetched successfully",
            "data" => $data
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "No products found",
            "data" => []
        ]);
    }
}

//order api 

//add


public function add_order()
{

    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;


    $user_id        = $this->input->post('user_id');
    $total_amount   = $this->input->post('total_amount');
    $order_status   = $this->input->post('order_status') ;

    if (empty($user_id)) {
        echo json_encode([
            "status" => false,
            "message" => "user_id required"
        ]);
        return;
    }

    $data = [
        "user_id"        => $user_id,
        "total_amount"   => $total_amount,
        "order_status"   => $order_status
    ];

    $insert = $this->Order_model->insert_order($data);

    if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "order added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to add order"
        ]);
    }
}

//update_order

public function update_order()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    $order= $this->Order_model->get_order_by_id($id);

    if (!$order) {
        echo json_encode([
            'status'=>false,
            'message'=>'Order not found or deleted'
        ]);
        return;
    }



    $data = [
        "user_id"      => $this->input->post('user_id'),
        "total_amount" => $this->input->post('total_amount'),
        "order_status" => $this->input->post('total_amount'),
    ];

    $update = $this->Order_model->update_order($id, $data);



    echo json_encode([
        "status" => $update,
        "message" => $update ? "Order updated" : "Update failed"
    ]);
}


//delete

public function delete_order()
{

$decoded = $this->verify_token();
$admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    
    $order = $this->Order_model->get_order_by_id($id);

    if (!$order) {
        echo json_encode([
            'status'=>false,
            'message'=>'Order ID not found or deleted'
        ]);
        return;
    }


    $delete = $this->Order_model->soft_delete_order($id);

    echo json_encode([
        "status" => $delete ? true : false,
        "message" => $delete ? "Order deleted" : "Delete failed"
    ]);
      
    
}


//list order
/*public function list_order()
{
   $decoded = $this->verify_token();
   $admin_id = $decoded->admin_id;

    $order = $this->Order_model->get_order();

    echo json_encode([
        "status" => true,
        "data" => $order
    ]);
}*/

public function list_order()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $orders = $this->Order_model->get_orders_with_items();

    echo json_encode([
        "status" => true,
        "data" => $orders
    ]);
}



//order_items


public function add_order_item()
{

    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;


    $order_id        = $this->input->post('order_id');
    $product_id   = $this->input->post('product_id');
    $quantity  = $this->input->post('quantity') ;
    $price  = $this->input->post('price') ;


    if (empty($order_id)) {
        echo json_encode([
            "status" => false,
            "message" => "order ID required"
        ]);
        return;
    }

    $data = [
        "order_id"   => $order_id,
        "product_id" => $product_id,
        "quantity"   => $quantity,
        "price"      => $price

    ];

    $insert = $this->Order_model->insert_order_items($data);

    if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "order items added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to add order items"
        ]);
    }
}

//update order items

public function update_order_item()
{
 

    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;


    $id = $this->input->post('id');

 


    $order_id    = $this->input->post('order_id');
    $product_id  = $this->input->post('product_id');
    $quantity    = $this->input->post('quantity') ;
    $price       = $this->input->post('price') ;


    if (empty($order_id)) {
        echo json_encode([
            "status" => false,
            "message" => "order ID required"
        ]);
        return;
    }

    $data = [
        "order_id"   => $order_id,
        "product_id" => $product_id,
        "quantity"   => $quantity,
        "price"      => $price

    ];

    $update = $this->Order_model->update_order_items($id,$data);

    if ($update) {
        echo json_encode([
            "status" => true,
            "message" => "order items updated successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to update order items"
        ]);
    }
}



    


//delete api


public function delete_order_items()
{

$decoded = $this->verify_token();
$admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    
    $order = $this->Order_model->get_order_items_by_id($id);

    if (!$order) {
        echo json_encode([
            'status'=>false,
            'message'=>'Order Items not found or deleted'
        ]);
        return;
    }


    $delete = $this->Order_model->soft_delete_order_items($id);

    echo json_encode([
        "status" => $delete ? true : false,
        "message" => $delete ? "Order item deleted" : "Delete failed"
    ]);
      
    
}


//list


public function list_order_items()
{

   $decoded = $this->verify_token();
   $admin_id = $decoded->admin_id;

    $order = $this->Order_model->get_order_items();

    echo json_encode([
        "status" => true,
        "data" => $order
    ]);
}

//update order status

public function update_order_status()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $id = $this->input->post('id');
    $order_status = $this->input->post('order_status');

    if (empty($id) || empty($order_status)) {
        echo json_encode([
            "status" => false,
            "message" => "Order ID and status are required"
        ]);
        return;
    }

    $data = [
        'order_status' => $order_status,
    ];

    // call model
    $update = $this->Order_model->update_order_status($id, $data);

    if ($update) {
        echo json_encode([
            "status" => true,
            "message" => "Order status updated successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to update order status"
        ]);
    }
}


//attribut api

//add


public function add_attribute()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;


    $attribute_name = $this->input->post('attribute_name');
    $status=$this->input->post('status');
   


    $data = [
        "attribute_name" => $attribute_name,
        "status"=>1
        
    ];

    $insert = $this->Attribute_model->insert_attribute($data);

    if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "Attribute added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to add attribute"
        ]);
    }
}

//update 
public function update_attribute()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;

    $id = $this->input->post('id');

    $attribute = $this->Attribute_model->get_attribute_by_id($id);

    if (!$attribute) {
        echo json_encode([
            'status'=>false,
            'message'=>'Attribute not found or deleted'
        ]);
        return;
    }

    if ($attribute['id'] != $id) {
        echo json_encode([
            'status'=>false,
            'message'=>'You are not allowed to update this attribute'
        ]);
        return;
    }


    $data = [
        "attribute_name" => $this->input->post('attribute_name'),
      
    ];

    $update = $this->Attribute_model->update_attribute($id, $data);



    echo json_encode([
        "status" => $update,
        "message" => $update ? "Attribute updated" : "Update failed"
    ]);
}

//delete 

public function delete_attribute()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;  

    
    $id = $this->input->post('id');

    $attribute = $this->Attribute_model->get_attribute_by_id($id);

    if (!$attribute) {
        echo json_encode([
            'status'=>false,
            'message'=>'Attribute ID not found or deleted'
        ]);
        return;
    }

 
    $delete = $this->Attribute_model->soft_delete_attribute($id);

    echo json_encode([
        "status" => $delete,
        "message" => "Attribute deleted"
    ]);
}

//list 

public function list_attribute()
{
   $decoded = $this->verify_token();
   $admin_id = $decoded->admin_id;

    $attributes= $this->Attribute_model->get_attributes();

    echo json_encode([
        "status" => true,
        "data" => $attributes
    ]);
}

}



