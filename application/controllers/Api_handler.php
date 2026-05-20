<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Mpdf\Mpdf;

class Api_handler extends CI_Controller {

    public function __construct() {
        parent::__construct();


        $this->load->library('session'); 
        $this->load->model('Admin_model');
        $this->load->model('Customer_model');
        $this->load->model('Category_model');
        $this->load->model('Sub_category_model');
        $this->load->model('Products_model');
        $this->load->model('Order_model');
        $this->load->model('Attribute_model');
        $this->load->model('Promotion_model');
        $this->load->model('Address_model');
        $this->load->model('Wishlist_model');
        $this->load->model('Cart_model');
        $this->load->library('upload');


        
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
  //  $phone_no = $this->input->post('phone_no');
    $password = $this->input->post('password');

    if (empty($email) ||  empty($password)) {
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
   
   /* $phone = $this->Admin_model->check_admin_phone($email, $phone_no);

    if (!$phone) {
        echo json_encode([
            'status' => false,
            'message' => 'Incorrect phone number'
        ]);
        return;
    }*/

    // Check password
    if (!password_verify($password, $admin['password'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Incorrect password'
        ]);
        return;
    }


// ✅ INSERT LOGIN LOG HERE
    $log_data = [
    'user_id' => $admin['id'],
    'user_type' => $admin['user_type'],
    'delete_status' => 0,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
    ];

    $this->db->insert('user_login_logs', $log_data);

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
        "data" => [
            "id" => $admin['id'],
            "firstname" => $admin['firstname'] ?? '',
            "lastname" => $admin['lastname'] ?? '',
            "email" => $admin['email'],
            "role" => "admin"
        ],
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

//customer login

public function customer_login()
{
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    if (empty($email) || empty($password)) {
        echo json_encode([
            'status' => false,
            'message' => 'All fields are required'
        ]);
        return;
    }

    // Check email
    $customer = $this->Customer_model->get_customer_by_email($email);

    if (!$customer) {
        echo json_encode([
            'status' => false,
            'message' => 'Incorrect email'
        ]);
        return;
    }

    // Check password
    if (!password_verify($password, $customer['password'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Incorrect password'
        ]);
        return;
    }


                // ✅ INSERT LOGIN LOG HERE
                $log_data = [
                    'user_id' => $customer['id'],
                    'user_type' => $customer['user_type'],
                    'delete_status' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $this->db->insert('user_login_logs', $log_data);


                // ✅ 🔥 ADD THIS (IMPORTANT)
                $this->session->set_userdata([
                'user_id' => $customer['id'],
                'logged_in' => true
    ]);

    // Generate JWT token
    $key = "this_is_my_super_secret_key_for_jwt_token_12345";

    $payload = [
        'customer_id' => $customer['id'],
        'email' => $customer['email'],
        'iat' => time(),
        'exp' => time() + 3600
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');

    echo json_encode([
        "status" => true,
        "message" => "Login successful",
        "data" => [
            "id" => $customer['id'],
            "firstname" => $customer['firstname'] ?? '',
            "lastname" => $customer['lastname'] ?? '',
            "email" => $customer['email'],
            "role" => "customer"
        ],
        "token" => $jwt
    ]);


}


//register customer

public function register()
{
    $firstname = $this->input->post('firstname');
    $lastname = $this->input->post('lastname');
    $dob = $this->input->post('dob');
    $gender= $this->input->post('gender');
    $email = $this->input->post('email');
    $phone_no = $this->input->post('phone_no');
    $password = $this->input->post('password');
    $address = $this->input->post('address');
    $city = $this->input->post('city');
    $state = $this->input->post('state');
    $country = $this->input->post('country');
    $pincode = $this->input->post('pincode');


    if (empty($firstname) || empty($lastname) || empty($dob) || empty($gender) || empty($phone_no) || empty($email) || empty($password) || empty($address) || empty($city) || empty($state) || empty($country) || empty($pincode)) {
        echo json_encode([
            'status' => false,
            'message' => 'All fields are required'
        ]);
        return;
    }

    // Check if email already exists
    $existing_customer = $this->Customer_model->get_customer_by_email($email);

    if ($existing_customer) {
        echo json_encode([
            'status' => false,
            'message' => 'Email already registered'
        ]);
        return;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new customer
    $customer_data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'password' => $hashed_password,
        'dob' => $dob,
        'gender' => $gender,
        'phone_no' => $phone_no,
        'address' => $address,
        'city' => $city,
        'state' => $state,
        'country' => $country,
        'pincode' => $pincode,
        'user_type' => 'customer',
        
    ];

    $customer_id = $this->Customer_model->insert_customer($customer_data);

    if ($customer_id) {
        echo json_encode([
            'status' => true,
            'message' => 'Customer registered successfully'
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Failed to register customer'
        ]);
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
        "status"=>$this->input->post('status'),
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
    $strike_price = $this->input->post('strike_price') ?? null;

    $description = $this->input->post('description');
    $stock = $this->input->post('stock');
    $badge = $this->input->post('badge');
    $rating = $this->input->post('rating');
    $status = $this->input->post('status') ?? '1';

    if (empty($sub_category_id) || empty($product_name) || empty($price) || empty($strike_price) || empty($stock)|| empty($badge) || empty($rating)){
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
        "strike_price" => $strike_price,
        "description" => $description,
        "stock" => $stock,
        "badge" => $badge,
        "rating" => $rating,
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
    // -------- MEDIA UPLOAD (COMBINED PHOTO + VIDEO LIKE WORK MODULE) --------

// Folders
$photoDir = './uploads/products/photos/';
$videoDir = './uploads/products/videos/';

if (!is_dir($photoDir)) mkdir($photoDir, 0777, true);
if (!is_dir($videoDir)) mkdir($videoDir, 0777, true);

$this->load->library('upload');

// Check media[]
if (!empty($_FILES['media']['name'][0])) {

    $files = $_FILES['media'];

    for ($i = 0; $i < count($files['name']); $i++) {

        $_FILES['file'] = [
            'name'     => $files['name'][$i],
            'type'     => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error'    => $files['error'][$i],
            'size'     => $files['size'][$i],
        ];

        $fileType = $_FILES['file']['type'];

        // ---------- PHOTO ----------
        if (in_array($fileType, ['image/jpeg','image/png','image/jpg'])) {

            $this->upload->initialize([
                'upload_path'   => $photoDir,
                'allowed_types' => 'jpg|jpeg|png',
                'encrypt_name'  => true
            ]);

            if ($this->upload->do_upload('file')) {
                $file = $this->upload->data();

                $this->db->insert('product_media_tbl', [
                    'product_id' => $product_id,   // or $id in update
                    'media_type' => 'photo',
                    'media_path' => 'uploads/products/photos/' . $file['file_name'],
                    'status'     => 1
                ]);
            }
        }

        // ---------- VIDEO ----------
        elseif (in_array($fileType, ['video/mp4','video/avi','video/mov','video/mkv'])) {

            $this->upload->initialize([
                'upload_path'   => $videoDir,
                'allowed_types' => 'mp4|avi|mov|mkv',
                'encrypt_name'  => true
            ]);

            if ($this->upload->do_upload('file')) {
                $file = $this->upload->data();

                $this->db->insert('product_media_tbl', [
                    'product_id' => $product_id,   // or $id in update
                    'media_type' => 'video',
                    'media_path' => 'uploads/products/videos/' . $file['file_name'],
                    'status'     => 1
                ]);
            }
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
        "strike_price" => $strike_price,
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

        if(empty($id)){
            echo json_encode([
                "status"=>false,
                "message"=>"ID missing "
            ]);
            return;
        }

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
        "strike_price" => $this->input->post('strike_price'),
        "description" => $this->input->post('description'),
        "stock" => $this->input->post('stock'),
        "badge" => $this->input->post('badge'),
        "rating" => $this->input->post('rating'),
        "status" => $this->input->post('status'),
    ];

    $update = $this->Products_model->update_product($id,$data);


// 🔥 DELETE ALL ATTRIBUTES FIRST
$this->db->where('product_id', $id);
$this->db->delete('product_attribute_tbl');

// 🔥 INSERT ALL AGAIN (MULTIPLE ALLOWED)
$attributes = $this->input->post('attributes');

if (!empty($attributes)) {
    foreach ($attributes as $attr) {

        if (!empty($attr['attribute_id']) && !empty($attr['value'])) {

            $this->db->insert('product_attribute_tbl', [
                "product_id" => $id,
                "attribute_id" => $attr['attribute_id'],
                "value" => $attr['value']
            ]);
        }
    }
}
// -------- MEDIA UPLOAD (COMBINED PHOTO + VIDEO LIKE WORK MODULE) --------

// Folders
$photoDir = './uploads/products/photos/';
$videoDir = './uploads/products/videos/';

if (!is_dir($photoDir)) mkdir($photoDir, 0777, true);
if (!is_dir($videoDir)) mkdir($videoDir, 0777, true);

$this->load->library('upload');

// Check media[]
if (!empty($_FILES['media']['name'][0])) {

    $files = $_FILES['media'];

    for ($i = 0; $i < count($files['name']); $i++) {

        $_FILES['file'] = [
            'name'     => $files['name'][$i],
            'type'     => $files['type'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error'    => $files['error'][$i],
            'size'     => $files['size'][$i],
        ];

        $fileType = $_FILES['file']['type'];

        // ---------- PHOTO ----------
        if (in_array($fileType, ['image/jpeg','image/png','image/jpg'])) {

            $this->upload->initialize([
                'upload_path'   => $photoDir,
                'allowed_types' => 'jpg|jpeg|png',
                'encrypt_name'  => true
            ]);

            if ($this->upload->do_upload('file')) {
                $file = $this->upload->data();

                $this->db->insert('product_media_tbl', [
                    'product_id' => $id,   // or $id in update
                    'media_type' => 'photo',
                    'media_path' => 'uploads/products/photos/' . $file['file_name'],
                    'status'     => 1
                ]);
            }
        }

        // ---------- VIDEO ----------
        elseif (in_array($fileType, ['video/mp4','video/avi','video/mov','video/mkv'])) {

            $this->upload->initialize([
                'upload_path'   => $videoDir,
                'allowed_types' => 'mp4|avi|mov|mkv',
                'encrypt_name'  => true
            ]);

            if ($this->upload->do_upload('file')) {
                $file = $this->upload->data();

                $this->db->insert('product_media_tbl', [
                    'product_id' => $id,   // or $id in update
                    'media_type' => 'video',
                    'media_path' => 'uploads/products/videos/' . $file['file_name'],
                    'status'     => 1
                ]);
            }
        }
    }
}
echo json_encode([
    "status" => true,
    "message" => "Product updated successfully"
]);
exit;
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

//previous media fetch

public function product_media_by_id()
{
    // -------- VALIDATION --------
    $product_id = $this->input->post('product_id');

    if (empty($product_id)) {
        echo json_encode([
            'status' => false,
            'message' => 'Product ID required',
            'data' => []
        ]);
        return;
    }

    // -------- FETCH MEDIA --------
    $this->db->select('id, media_type, media_path');
    $this->db->from('product_media_tbl');
    $this->db->where('product_id', $product_id);
    $this->db->where('delete_status', 0);

    $query = $this->db->get()->result_array();

    // -------- RESPONSE --------
    echo json_encode([
        'status'  => true,
        'message' => 'Media fetched successfully',
        'data'    => $query
    ]);
}


//delete previous media 

public function delete_product_media()
{
    $media_id = $this->input->post('media_id');

    if (!$media_id) {
        echo json_encode(['status'=>false,'message'=>'Media ID required']);
        return;
    }

    $this->db->where('id', $media_id)
             ->update('product_media_tbl', ['delete_status' => 1]);

    echo json_encode([
        'status' => true,
        'message' => 'Media deleted successfully'
    ]);
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




private function upload_file($field, $path, $types)
{
    $config = [
        'upload_path'   => $path,
        'allowed_types' => $types,
        'max_size'      => 51200, // 50MB
        'encrypt_name'  => true
    ];

    $this->upload->initialize($config);

    if (!$this->upload->do_upload($field)) {
        log_message('error', $this->upload->display_errors());
        return false;
    }

    $data = $this->upload->data();
    return $path . $data['file_name'];
}

//promotions coupon api

//add promotion

public function add_promotion()
{
   $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;   

    $data = [
        "coupon_code" => $this->input->post('coupon_code'),
        "coupon_type" => $this->input->post('coupon_type'),
        "discount_type" => $this->input->post('discount_type'),
        "discount_value" => $this->input->post('discount_value'),
        "validity" => $this->input->post('validity'),
        "status" => $this->input->post('status'),
        "description" => $this->input->post('description')
    ];
    
    $insert = $this->Promotion_model->insert_promotion($data);
        if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "coupon added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to add coupon"
        ]);
    }
    
    
}
/*
public function add_promotion()
{
    // ✅ CHECK ADMIN SESSION (instead of token)
    if (!$this->session->userdata('admin_id')) {
        echo json_encode([
            "status" => false,
            "message" => "Unauthorized access"
        ]);
        return;
    }

    $data = [
        "coupon_code" => $this->input->post('coupon_code'),
        "coupon_type" => $this->input->post('coupon_type'),
        "discount_type" => $this->input->post('discount_type'),
        "discount_value" => $this->input->post('discount_value'),
        "validity" => $this->input->post('validity'),
        "status" => $this->input->post('status'),
        "description" => $this->input->post('description')
    ];

    $insert = $this->Promotion_model->insert_promotion($data);

    if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "Coupon added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to add coupon"
        ]);
    }

    exit;
}*/
//update promotion

public function update_promotion()
{
   $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;   

    $id = $this->input->post('id');

    $promotion = $this->Promotion_model->get_promotion_by_id($id);

    if (!$promotion) {
        echo json_encode([
            'status'=>false,
            'message'=>'Coupon not found or deleted'
        ]);
        return;
    }

    $data = [
        "coupon_code" => $this->input->post('coupon_code'),
        "coupon_type" => $this->input->post('coupon_type'),
        "discount_type" => $this->input->post('discount_type'),
        "discount_value" => $this->input->post('discount_value'),
        "validity" => $this->input->post('validity'),
        "status" => $this->input->post('status'),
        "description" => $this->input->post('description')
    ];
    
    $update = $this->Promotion_model->update_promotion($id, $data);
    
    echo json_encode([
        "status" => $update,
        "message" => $update ? "Coupon updated" : "Update failed"
    ]);
    exit;

}

//delete promotion

public function delete_promotion()
{
    $decoded = $this->verify_token();
    $admin_id = $decoded->admin_id;  

    
    $id = $this->input->post('id');

    $promotion = $this->Promotion_model->get_promotion_by_id($id);

    if (!$promotion) {
        echo json_encode([
            'status'=>false,
            'message'=>'Coupon ID not found or deleted'
        ]);
        return;
    }

 
    $delete = $this->Promotion_model->soft_delete_promotion($id);

    echo json_encode([
        "status" => $delete,
        "message" => "Coupon deleted"
    ]); 
}

//list promotion    

public function list_promotion()
{
   $decoded = $this->verify_token();
   $admin_id = $decoded->admin_id;

    $promotions= $this->Promotion_model->get_promotions();

    echo json_encode([
        "status" => true,
        "data" => $promotions
    ]);
}





//multiple address api

public function add_address()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;   

   $user_id = $this->input->post('user_id');
    $address_type = $this->input->post('address_type');
    $address = $this->input->post('address');
    $city = $this->input->post('city');
    $state = $this->input->post('state');
    $pincode = $this->input->post('pincode');
    $country = $this->input->post('country');

  if (empty($user_id) || empty($address_type) || empty($address) || empty($city) || empty($state) || empty($pincode) || empty($country)) {
        echo json_encode([
            "status" => false,
            "message" => "All fields are required"
        ]);
        return;
    }

    $data = [
       "user_id" => $user_id,
        "address_type" => $address_type,
        "address" => $address,
        "city" => $city,
        "state" => $state,
        "pincode" => $pincode,
        "country" => $country
    ];

    $insert = $this->Address_model->insert_address($data);

    if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "Address added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to add address"
        ]);
    }
}

//update address

public function update_address()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;   

    $id = $this->input->post('id');

    $address = $this->Address_model->get_address_by_id($id);

    if (!$address) {
        echo json_encode([
            'status'=>false,
            'message'=>'Address not found or deleted'
        ]);
        return;
    }

    $data = [
        "user_id" => $this->input->post('user_id'),
        "address_type" => $this->input->post('address_type'),
        "address" => $this->input->post('address'),
        "city" => $this->input->post('city'),
        "state" => $this->input->post('state'),
        "pincode" => $this->input->post('pincode'),
        "country" => $this->input->post('country')
    ];

    $update = $this->Address_model->update_address($id, $data);
    
    echo json_encode([
        "status" => $update,
        "message" => $update ? "Address updated" : "Update failed"
    ]);
}

//delete address    

public function delete_address()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;    

    
    $id = $this->input->post('id');

    $address = $this->Address_model->get_address_by_id($id);

    if (!$address) {
        echo json_encode([
            'status'=>false,
            'message'=>'Address ID not found or deleted'
        ]);
        return;
    }

 
    $delete = $this->Address_model->soft_delete_address($id);

   if ($delete) {
        echo json_encode([
            "status" => true,
            "message" => "Address deleted"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to delete address"
        ]);
    }

}

//list address

public function list_address()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;
    
    $user_id = $this->input->post('user_id');

    $addresses= $this->Address_model->get_addresses($user_id);

    echo json_encode([
        "status" => true,
        "data" => $addresses
    ]);
}

//customer req form

public function customer_request()
{
     

   // $user_id = $this->input->post('user_id');
    $name= $this->input->post('name');
    $email= $this->input->post('email');
    $subject= $this->input->post('subject');
    $message= $this->input->post('message');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode([
            "status" => false,
            "message" => "All fields are required"
        ]);
        return;
    }

    $data = [
       // "user_id" => $user_id,
        "name" => $name,
        "email" => $email,  
        "subject" => $subject,
        "message" => $message
    ];

    $insert = $this->Customer_model->insert_request($data);

    if ($insert) {
        echo json_encode([
            "status" => true,
            "message" => "Request submitted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to submit request"
        ]);
    }

}

//wishlist api

//add to wishlist

public function add_to_wishlist()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;  

    $product_id = $this->input->post('product_id');

    if (empty($product_id)) {
        echo json_encode([
            "status" => false,
            "message" => "Product ID required"
        ]);
        return;
    }

    $result = $this->Wishlist_model->add_to_wishlist($user_id, $product_id);

    if ($result == 'added') {
        echo json_encode([
            "status" => true,
            "message" => "Added to wishlist"
        ]);
    } elseif ($result == 'updated') {
        echo json_encode([
            "status" => true,
            "message" => "Added again"
        ]);
    } elseif ($result === false) {
        echo json_encode([
            "status" => false,
            "message" => "Already in wishlist"
        ]);
    }
}



//remove from wishlist

public function remove_from_wishlist()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;  

    // $user_id = $this->input->post('user_id');
    $product_id = $this->input->post('product_id');

   /* if (empty($user_id) || empty($product_id)) {
        echo json_encode([
            "status" => false,
            "message" => "User ID and Product ID are required"
        ]);
        return;
    }*/

    $delete = $this->Wishlist_model->remove_from_wishlist($user_id, $product_id);

    echo json_encode([
    "status" => $delete > 0,
    "message" => $delete > 0 ? "Removed successfully" : "Already removed"
    ]);;
}



//wishlist list
/*public function wishlist()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;  
    
 //   $user_id = $this->input->post('user_id');

/*    if (empty($user_id)) {
        echo json_encode([
            "status" => false,
            "message" => "User ID is required"
        ]);
        return;
    }*/
/*
    $wishlist = $this->Wishlist_model->get_wishlist_by_user_id($user_id);

    echo json_encode([
        "status" => true,
        "data" => $wishlist
    ]);
}*/


public function wishlist()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;  

    // ✅ get data from model
    $wishlist = $this->Wishlist_model->get_wishlist_by_user_id($user_id);

    // ✅ ADD IMAGE FULL URL HERE
    foreach ($wishlist as &$item) {
        $item['product_image'] = base_url($item['product_image']);
    }

    // ✅ response
    echo json_encode([
        "status" => true,
        "data" => $wishlist
    ]);
}
/*
public function wishlist_count()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;
    
    // $product_id = $this->input->post('product_id');
    $count = $this->Wishlist_model->get_wishlist_count($user_id);

    echo json_encode([
        "status" => true,
        "count" => $count
    ]);
}*/

public function wishlist_count()
{
    $decoded = $this->verify_token();

    // ✅ FIX: check token first
    if (!$decoded || !isset($decoded->customer_id)) {
        echo json_encode([
            "status" => false,
            "message" => "Invalid token"
        ]);
        return;
    }

    $user_id = $decoded->customer_id;

    $count = $this->Wishlist_model->get_wishlist_count($user_id);

    echo json_encode([
        "status" => true,
        "count" => $count
    ]);
}

//cart api

//add
/*
public function add_to_cart()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $product_id = $this->input->post('product_id');
    $quantity = $this->input->post('quantity');
    $cart_status = $this->input->post('cart_status');

    /*if (empty($product_id) || empty($quantity)) {
        echo json_encode([
            "status" => false,
            "message" => "Product ID and quantity are required"
        ]);
        return;
    }*

    $result = $this->Cart_model->added_to_cart($user_id, $product_id, $quantity);

    if ($result == 'added') {
        echo json_encode([
            "status" => true,
            "message" => "Added to cart"
        ]);
    } elseif ($result == 'updated') {
        echo json_encode([
            "status" => true,
            "message" => "Quantity updated"
        ]);
    } elseif ($result === false) {
        echo json_encode([
            "status" => false,
            "message" => "Already in cart"
        ]);
    }
}
*/


public function add_to_cart()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    
    $product_id = $this->input->post('product_id');
    $quantity = $this->input->post('quantity');

   /* if (empty($product_id) || empty($quantity)) {
        echo json_encode([
            "status" => false,
            "message" => "Product ID and quantity are required"
        ]);
        return;
    }*/

    $result = $this->Cart_model->added_to_cart($user_id, $product_id, $quantity);

    if ($result == 'added') {
        echo json_encode([
            "status" => true,
            "message" => "Added to cart"
        ]);
    } elseif ($result == 'updated') {
        echo json_encode([
            "status" => true,
            "message" => "Quantity updated"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Something went wrong"
        ]);
    }
}

//remove from cart

public function remove_from_cart()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $product_id = $this->input->post('product_id');

    if (empty($product_id)) {
        echo json_encode([
            "status" => false,
            "message" => "Product ID required"
        ]);
        return;
    }

    // ✅ call MODEL
    $delete = $this->Cart_model->remove_from_cart($user_id, $product_id);

    echo json_encode([
        "status" => $delete > 0,
        "message" => $delete > 0 ? "Removed successfully" : "Already removed"
    ]);
}

/*
public function remove_from_cart()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $product_id = $this->input->post('product_id');

    if (empty($product_id)) {
        echo json_encode([
            "status" => false,
            "message" => "Product ID required"
        ]);
        return;
    }

    $delete = $this->Cart_model->remove_from_cart($user_id, $product_id);

    echo json_encode([
        "status" => $delete > 0,
        "message" => $delete > 0 ? "Removed successfully" : "Already removed"
    ]);
}*/

//cart list

public function cart()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $cart = $this->Cart_model->get_cart_by_user_id($user_id);

    echo json_encode([
        "status" => true,
        "data" => $cart
    ]);
}

//update cart qty

public function update_cart_quantity()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $product_id = $this->input->post('product_id');
    $quantity = $this->input->post('quantity');

    $this->db->where('user_id', $user_id);
    $this->db->where('product_id', $product_id);

    $this->db->update('cart_tbl', [
        'quantity' => $quantity
    ]);

    echo json_encode(["status" => true]);
}
//cart count

public function cart_count()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $count = $this->Cart_model->get_cart_count($user_id);

    echo json_encode([
        "status" => true,
        "count" => $count
    ]);

}
//order api add with cart items with payment methods

/*
public function place_order()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $payment_method = $this->input->post('payment_method') ?? 'COD';
    $address_id = $this->input->post('address_id');

    // ✅ Get cart
    $cart_items = $this->Cart_model->get_cart_by_user_id($user_id);

    if (empty($cart_items)) {
        echo json_encode([
            "status" => false,
            "message" => "Cart is empty"
        ]);
        return;
    }

    // ✅ Calculate total (IMPORTANT 🔥)
    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['qty'];
    }

    // ✅ Start transaction
    $this->db->trans_start();

    // ✅ Create order
    $order_data = [
        "user_id" => $user_id,
        "total_amount" => $total_amount,
        "order_status" => "pending",
        "address_id" => $address_id
    ];

    $order_id = $this->Order_model->insert_order($order_data);

    if (!$order_id) {
        echo json_encode([
            "status" => false,
            "message" => "Failed to create order"
        ]);
        return;
    }

    // ✅ Insert order items
    foreach ($cart_items as $item) {
        $order_item_data = [
            "order_id" => $order_id,
            "product_id" => $item['product_id'],
            "quantity" => $item['qty'],
            "price" => $item['price']
        ];
        $this->Order_model->insert_order_items($order_item_data);
    }

    // ✅ Insert payment
    $payment_data = [
        "order_id" => $order_id,
        "payment_method" => $payment_method,
        "amount" => $total_amount,
        "payment_status" => "pending",
        "transaction_id" => uniqid('txn_'),
    ];
    $this->Order_model->insert_payment_details($payment_data);

    // ✅ Clear cart
    $this->Cart_model->clear_cart($user_id);

    // ✅ Complete transaction
    $this->db->trans_complete();

    echo json_encode([
        "status" => true,
        "message" => "Order placed successfully",
        "order_id" => $order_id
    ]);
}*/

/*
public function place_order()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $payment_method = $this->input->post('payment_method') ?? 'COD';
    $address_id = $this->input->post('address_id');

    $coupon_id=$this->input->post('coupon_id');

    // ✅ Get cart items
    $cart_items = $this->Cart_model->get_cart_by_user_id($user_id);

    if (empty($cart_items)) {
        echo json_encode([
            "status" => false,
            "message" => "Cart is empty"
        ]);
        return;
    }

    // ✅ Calculate subtotal
    $subtotal = 0;
    foreach ($cart_items as $item) {
        $subtotal += $item['price'] * $item['qty'];
    }

    // ✅ GST (5%)
    $gst = $subtotal * 0.05;

    // ✅ Shipping
    $shipping = 99;

    // ✅ Final total
    $total_amount = $subtotal + $gst + $shipping;

    // ✅ Start transaction
    $this->db->trans_start();

    // ✅ Insert order
    $order_data = [
        "user_id" => $user_id,
        "subtotal" => $subtotal,
        "gst" => $gst,
        "shipping" => $shipping,
        "total_amount" => $total_amount,
        "order_status" => "pending",
        "address_id" => $address_id,
        "coupon_id" =>$coupon_id
    ];

    $order_id = $this->Order_model->insert_order($order_data);

    if (!$order_id) {
        $this->db->trans_rollback();
        echo json_encode([
            "status" => false,
            "message" => "Failed to create order"
        ]);
        return;
    }

    // ✅ Insert order items
    foreach ($cart_items as $item) {
       // $order_item_data = [
         //   "order_id" => $order_id,
           // "product_id" => $item['product_id'],
            //"quantity" => $item['qty'],
            //"price" => $item['price']
        //];

        $unit_price = $item['price'];
        $qty = $item['qty'];

    $order_item_data = [
    "order_id" => $order_id,
    "product_id" => $item['product_id'],
    "quantity" => $qty,
    "price" => $unit_price * $qty // ✅ total price
];
        $this->Order_model->insert_order_items($order_item_data);
    }

    // ✅ Insert payment
    $payment_data = [
        "order_id" => $order_id,
        "payment_method" => $payment_method,
        "amount" => $total_amount,
        "payment_status" => "pending",
        "transaction_id" => uniqid('txn_'),
    ];

    $this->Order_model->insert_payment_details($payment_data);

    // ✅ Clear cart
    $this->Cart_model->clear_cart($user_id);

    // ✅ Complete transaction
    $this->db->trans_complete();

    echo json_encode([
        "status" => true,
        "message" => "Order placed successfully",
        "order_id" => $order_id
    ]);
}*/

public function place_order()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $payment_method = $this->input->post('payment_method') ?? 'COD';
    $address_id     = $this->input->post('address_id');
  //  $coupons_id      = $this->input->post('coupon_id');
   // $discounted_value = $this->input->post('discount_value');

    // ✅ GET ADDRESS (FOR GST LOGIC)
    $address = $this->Address_model->get_address_by_id($address_id);
    $state   = strtolower(trim($address['state'] ?? ''));

    // ✅ GET CART ITEMS
    $cart_items = $this->Cart_model->get_cart_by_user_id($user_id);

    if (empty($cart_items)) {
        echo json_encode([
            "status" => false,
            "message" => "Cart is empty"
        ]);
        return;
    }

    // ✅ CALCULATE SUBTOTAL
    $subtotal = 0;

    foreach ($cart_items as $item) {
        $price = (float) $item['price'];
        $qty   = (int) $item['quantity']; // ✅ FIXED

        $subtotal += $price * $qty;
    }

    // ✅ GET COUPON FROM SESSION
    $coupon = $this->session->userdata('coupon_data');

    $discount = 0;
    $coupon_id = null;

    if (!empty($coupon)) {
        $coupon_id = $coupon['coupon_id'];

        if ($coupon['discount_type'] == 'percent') {
            $discount = ($subtotal * $coupon['discount_value']) / 100;
        } else {
            $discount = $coupon['discount_value'];
        }

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }
    }

    // ✅ AFTER DISCOUNT
    $after_discount = $subtotal - $discount;

    // ✅ GST CALCULATION
    $cgst = $sgst = $igst = $gst = 0;

    if ($state == "maharashtra") {
        $cgst = ($after_discount * 2.5) / 100;
        $sgst = ($after_discount * 2.5) / 100;
        $gst  = $cgst + $sgst;
    } else {
        $igst = ($after_discount * 5) / 100;
        $gst  = $igst;
    }

    // ✅ SHIPPING
    $shipping = 99;

    // ✅ FINAL TOTAL
    $total_amount = $after_discount + $gst + $shipping;

    // ✅ START TRANSACTION
    $this->db->trans_start();

    // ✅ INSERT ORDER
    $order_data = [
        "user_id"      => $user_id,
        "subtotal"     => round($subtotal),
        "discount_value" => round($discount),
        "gst"          => round($gst),
        "cgst"         => round($cgst),
        "sgst"         => round($sgst),
        "igst"         => round($igst),
        "shipping"     => $shipping,
        "total_amount" => round($total_amount),
        "order_status" => "pending",
        "address_id"   => $address_id,
        "coupon_id"    => $coupon_id
    ];

    $order_id = $this->Order_model->insert_order($order_data);

    if (!$order_id) {
        $this->db->trans_rollback();
        echo json_encode([
            "status" => false,
            "message" => "Order creation failed"
        ]);
        return;
    }

    // ✅ INSERT ORDER ITEMS
    foreach ($cart_items as $item) {

        $price = (float) $item['price'];
        $qty   = (int) $item['quantity'];

        $this->Order_model->insert_order_items([
            "order_id"   => $order_id,
            "product_id" => $item['product_id'],
            "quantity"   => $qty,
            "price"      => $price * $qty // total price
        ]);
    }

    // ✅ PAYMENT ENTRY
    $this->Order_model->insert_payment_details([
        "order_id"       => $order_id,
        "payment_method" => $payment_method,
        "amount"         => round($total_amount),
        "payment_status" => "pending",
        "transaction_id" => uniqid('txn_')
    ]);

    // ✅ HARD DELETE CART
    $this->db->where('user_id', $user_id);
    $this->db->delete('cart_tbl');

    // ✅ CLEAR COUPON SESSION
    $this->session->unset_userdata('coupon_data');

    // ✅ COMPLETE TRANSACTION
    $this->db->trans_complete();

    echo json_encode([
        "status" => true,
        "message" => "Order placed successfully",
        "order_id" => $order_id
    ]);
}


public function apply_coupon()
{
 //   $decoded = $this->verify_token();
   // $user_id = $decoded->customer_id;

       $user_id = $this->session->userdata('user_id');


    $code  = $this->input->post('coupon_code');
    $state = $this->input->post('state');

    $coupon = $this->Promotion_model->get_coupon_by_code($code);

    if (!$coupon) {
        echo json_encode(["status" => false, "message" => "Invalid coupon"]);
        return;
    }

    if ($coupon['status'] != 'Active') {
        echo json_encode(["status" => false, "message" => "Coupon not active"]);
        return;
    }

    // ✅ GET CART ITEMS (IMPORTANT FIX)
    $items = $this->Cart_model->get_cart_by_user_id($user_id);

    if (empty($items)) {
        echo json_encode(["status" => false, "message" => "Cart is empty"]);
        return;
    }

    // ✅ CALCULATE SUBTOTAL (SAME AS CHECKOUT)
    $subtotal = 0;

    foreach ($items as $item) {
        $price = (float) ($item['price'] ?? 0);
        $qty   = (int) ($item['quantity'] ?? 1); // or qty if used

        $subtotal += $price * $qty;
    }

    // ✅ DISCOUNT
    if ($coupon['discount_type'] == 'percent') {
        $discount = ($subtotal * $coupon['discount_value']) / 100;
    } else {
        $discount = $coupon['discount_value'];
    }

    if ($discount > $subtotal) {
        $discount = $subtotal;
    }

    // ✅ AFTER DISCOUNT
    $after_discount = $subtotal - $discount;

    // safety
    if ($after_discount < 0) {
        $after_discount = 0;
    }

    // ✅ GST (CORRECT LOGIC)
    $cgst = $sgst = $igst = $gst = 0;

    if (strtolower(trim($state)) == "maharashtra") {
        $cgst = ($after_discount * 2.5) / 100;
        $sgst = ($after_discount * 2.5) / 100;
        $gst  = $cgst + $sgst;
    } else {
        $igst = ($after_discount * 5) / 100;
        $gst  = $igst;
    }

    // ✅ TOTAL
    $shipping = 99;
    $final_total = $after_discount + $gst + $shipping;

    // ✅ STORE RAW COUPON ONLY
    $this->session->set_userdata('coupon_data', [
        'coupon_id'      => $coupon['id'],
        'coupon_code'    => $coupon['coupon_code'],
        'discount_type'  => $coupon['discount_type'],
        'discount_value' => $coupon['discount_value']
    ]);

   

    echo json_encode([
    "status" => true,
    "message" => "Coupon applied successfully",
    "subtotal" => round($subtotal),
    "discount" => round($discount),
    "gst" => round($gst),
    "cgst" => round($cgst),
    "sgst" => round($sgst),
    "igst" => round($igst),
    "shipping" => $shipping,
    "final_total" => round($final_total),

    // ✅ ADD THIS
    "discount_type" => $coupon['discount_type'],
    "discount_value" => $coupon['discount_value']
]);

}

//remove coupon

public function remove_coupon()
{
    // ✅ remove coupon from session
    $this->session->unset_userdata('coupon_data');

    echo json_encode([
        "status" => true,
        "message" => "Coupon removed successfully"
    ]);
}


//shop

//get all products by categories 

/*
public function products_by_category()
{
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $category_id = $this->input->post('category_id');

    /*if (empty($category_id)) {
       echo json_encode([
          "status" => false,
            "message" => "Category ID is required"
        ]);
        return;
    }

    $products = $this->Product_model->get_products_by_category($category_id);

    echo json_encode([
        "status" => true,
        "data" => $products
    ]);
}*/
/*
public function products_by_category()
{
    $category_id = $this->input->post('category_id');

    $products = $this->Product_model->get_products_by_category($category_id);

    echo json_encode([
        "status" => !empty($products),
        "data" => $products
    ]);
}*/

/*
public function products_by_category()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $category_id = $this->input->post('category_id');

    $products = $this->Product_model->get_products_by_category($category_id);

    echo json_encode([
        "status" => true,
        "data" => $products
    ]);
}


public function products_by_category()
{
    // ❌ REMOVE THIS
    // $decoded = $this->verify_token();
    // $user_id = $decoded->customer_id;

    $category_id = $this->input->post('category_id');

    $products = $this->Product_model->get_products_by_category($category_id);

    echo json_encode([
        "status" => true,
        "data" => $products
    ]);
}
*/

public function products_by_category()
{
    header('Content-Type: application/json');

    $category_id = $this->input->post('category_id');

    $products = $this->Products_model->get_products_by_category($category_id);

 //   $sub_category_ids = $this->Subcategory_model->get_subcategories($category_id);

    echo json_encode([
        "status" => true,
        "data" => $products
     //   "sub_category_ids" => $sub_category_ids
    ]);
}


public function get_subcategories_by_category()
{
    $category_id = $this->input->post('category_id');

    $this->load->model('Products_model');

    $subcategories = $this->Products_model->get_subcategories($category_id);

    echo json_encode([
        "status" => true,
        "data" => $subcategories
    ]);
}


/*
public function track_order()
{
    $order_number = $this->input->post('order_number');

    $order = $this->db->where('order_number', $order_number)
                      ->get('order_tbl')
                      ->row();

    if ($order) {
        $data['order_status'] = $order->status;
    } else {
        $data['order_status'] = "Order not found";
    }

    $this->load->view('frontend/pages/track_order', $data);
}


public function track_order()
{
    $order_number = $this->input->post('order_number');

    $order = $this->db->where('id', $order_number) // or order_number if exists
                      ->get('order_tbl')
                      ->row();

    if ($order) {
        $data['order_status'] = $order->order_status; // ✅ FIX
    } else {
        $data['order_status'] = "Order not found";
    }

    $this->load->view('frontend/pages/track_order', $data);
}
*/

/*
public function track_order()
{
    //$input = $this->input->post('order_number');

   
    echo $this->input->get('order_number');
exit;

    // Convert PM-0032 → 32
    $order_id = preg_replace('/\D/', '', $input);

    $order = $this->db->where('id', $order_id)
                      ->get('order_tbl')
                      ->row();

    if ($order) {
        $data['order_status'] = $order->order_status;
    } else {
        $data['order_status'] = "Order not found";
    }

    $this->load->view('frontend/pages/track_order', $data);
}
*/

public function track_order_api()
{
    header('Content-Type: application/json');

    // ✅ Verify user
    $decoded = $this->verify_token();
    $user_id = $decoded->customer_id;

    $input = $this->input->post('order_number');

    if (empty($input)) {
        echo json_encode([
            'status' => false,
            'message' => 'Order number required'
        ]);
        return;
    }

    // Convert PM-0032 → 32
    $order_id = preg_replace('/\D/', '', $input);

    if (empty($order_id)) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid order number'
        ]);
        return;
    }

    // 🔐 SECURE QUERY
    $order = $this->db->where('id', $order_id)
                      ->where('user_id', $user_id) // ✅ KEY FIX
                      ->get('order_tbl')
                      ->row();

    if ($order) {
        echo json_encode([
            'status' => true,
            'order_status' => $order->order_status
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'Order not found'
        ]);
    }
}



//invoice api

//insert

public function insert_invoice()
{
    // ✅ Verify Token
     //$decoded = $this->verify_token();
    //$admin_id = $decoded->admin_id;

    // ✅ Get Order ID
    $order_id = $this->input->post('order_id');

    // ✅ Validate Order ID
    if (empty($order_id)) {

        echo json_encode(array(

            'status' => false,

            'message' => 'Order ID required'
        ));

        return;
    }

    $result = $this->Order_model->insert_invoice($order_id);

    // ✅ Response
    echo json_encode($result);
}

/*

public function download_invoice_pdf($order_id = 0)
{
    $order_id = (int) $order_id;

    // ✅ Get Invoice Data
    $invoice_data = $this->db
        ->where('fk_order_id', $order_id)
        ->get('invoice_tbl')
        ->result();

    // ✅ Check Invoice Exists
    if (empty($invoice_data)) {

        show_error('Invoice not found');
    }

    // ✅ First Row
    $first = $invoice_data[0];

    // ✅ Prepare Items Array
    $items = array();

    foreach ($invoice_data as $item) {

        $items[] = array(

            'sku' => $item->sku ?? '',

            'name' => $item->product_name ?? '',

            'qty' => $item->quantity ?? 0,

            'rate' => '₹' . number_format(
                $item->rate ?? 0,
                2
            ),

            'amount' => '₹' . number_format(
                $item->amount ?? 0,
                2
            )
        );
    }

    // ✅ View Data
    $data = array(

        'subtitle' => 'Invoice PDF Preview',

        'invoice_meta' => array(

            'invoice_id' => $first->fk_order_id,

            'invoice_no' => $first->invoice_no ?? '',

            'order_no' => 'PM-' . str_pad(
                $first->fk_order_id,
                4,
                '0',
                STR_PAD_LEFT
            ),

            'invoice_date' => !empty($first->invoice_date)
                ? date(
                    'd M Y',
                    strtotime($first->invoice_date)
                )
                : '',

            'due_date' => !empty($first->due_date)
                ? date(
                    'd M Y',
                    strtotime($first->due_date)
                )
                : '',

            'status' => ucfirst(
                $first->status ?? 'Pending'
            )
        ),

        'billing' => array(

            'customer_name' => 'Mrunali Jadhav',

            'company_name' => '',

            'address' => 'Shivaji Maharaj Chowk, Badlapur, Maharashtra, India, 421503',

            'phone' => '7894561230',

            'email' => 'mrunali1703@gmail.com',

            'gst' => $first->gstin ?? ''
        ),

        'summary' => array(

            'sub_total' => '₹' . number_format(
                $first->sub_total ?? 0,
                2
            ),

            'discount' => '₹' . number_format(
                $first->discount ?? 0,
                2
            ),

            'tax' => '₹' . number_format(
                $first->tax ?? 0,
                2
            ),

            'shipping' => '₹' . number_format(
                $first->shipping ?? 0,
                2
            ),

            'grand_total' => '₹' . number_format(
                $first->grand_total ?? 0,
                2
            )
        ),

        'items' => $items
    );

    // ✅ Load PDF View
    $html = $this->load->view(
        'admin/pages/invoice_pdf',
        $data,
        true
    );

    // ✅ mPDF
    $mpdf = new \Mpdf\Mpdf([

        'mode' => 'utf-8',

        'format' => 'A4',

        'margin_left' => 10,

        'margin_right' => 10,

        'margin_top' => 10,

        'margin_bottom' => 10
    ]);

    // ✅ Load CSS File
    $stylesheet = file_get_contents(
        FCPATH . 'assets/css/invoice.css'
    );

    // ✅ Apply CSS
    $mpdf->WriteHTML($stylesheet, 1);

    // ✅ Write HTML
    $mpdf->WriteHTML($html, 2);

    // ✅ Download PDF
    $mpdf->Output(
        'Invoice_' . $order_id . '.pdf',
        'D'
    );
}

*/

public function download_invoice_pdf($order_id = 0)
{
    $order_id = (int) $order_id;

    // ✅ Get Invoice Data
    $invoice_data = $this->db
        ->where('fk_order_id', $order_id)
        ->get('invoice_tbl')
        ->result();

    // ✅ Check Invoice Exists
    if (empty($invoice_data)) {

        show_error('Invoice not found');
    }

    // ✅ First Row
    $first = $invoice_data[0];

    // ✅ Get Address
    $address = $this->db
        ->where('id', $first->fk_address_id)
        ->get('address_book_tbl')
        ->row();

    // ✅ Get Customer
    $customer = $this->db
        ->where('id', $first->fk_user_id)
        ->get('users_tbl')
        ->row();

    // ✅ Prepare Items Array
    $items = array();

    foreach ($invoice_data as $item) {

        $items[] = array(

            'sku' => $item->sku ?? '',

            'name' => $item->product_name ?? '',

            'qty' => $item->quantity ?? 0,

            'rate' => '₹' . number_format(
                $item->rate ?? 0,
                2
            ),

            'amount' => '₹' . number_format(
                $item->amount ?? 0,
                2
            )
        );
    }

    // ✅ View Data
    $data = array(

        'subtitle' => 'Invoice PDF Preview',

        'invoice_meta' => array(

            'invoice_id' => $first->fk_order_id,

            'invoice_no' => $first->invoice_no ?? '',

            'order_no' => 'PM-' . str_pad(
                $first->fk_order_id,
                4,
                '0',
                STR_PAD_LEFT
            ),

            'invoice_date' => !empty($first->invoice_date)
                ? date(
                    'd M Y',
                    strtotime($first->invoice_date)
                )
                : '',

            'due_date' => !empty($first->due_date)
                ? date(
                    'd M Y',
                    strtotime($first->due_date)
                )
                : '',

            'status' => ucfirst(
                $first->status ?? 'Pending'
            )
        ),

        // ✅ Dynamic Billing Data
        'billing' => array(

            'customer_name' => trim(
                ($customer->firstname ?? '') . ' ' .
                ($customer->lastname ?? '')
            ),

            'company_name' => '',

            'address' => ($address->address ?? '') . ', ' .
                         ($address->city ?? '') . ', ' .
                         ($address->state ?? '') . ', ' .
                         ($address->country ?? '') . ' - ' .
                         ($address->pincode ?? ''),

            'phone' => $customer->phone_no ?? '',

            'email' => $customer->email ?? '',

            'gst' => $first->gstin ?? ''
        ),

        'summary' => array(

            'sub_total' => '₹' . number_format(
                $first->sub_total ?? 0,
                2
            ),

            'discount' => '₹' . number_format(
                $first->discount ?? 0,
                2
            ),

            'tax' => '₹' . number_format(
                $first->tax ?? 0,
                2
            ),

            'shipping' => '₹' . number_format(
                $first->shipping ?? 0,
                2
            ),

            'grand_total' => '₹' . number_format(
                $first->grand_total ?? 0,
                2
            )
        ),

        'items' => $items
    );

    // ✅ Load PDF View
    $html = $this->load->view(
        'admin/pages/invoice_pdf',
        $data,
        true
    );

    // ✅ mPDF
    $mpdf = new \Mpdf\Mpdf([

        'mode' => 'utf-8',

        'format' => 'A4',

        'margin_left' => 10,

        'margin_right' => 10,

        'margin_top' => 10,

        'margin_bottom' => 10
    ]);

    // ✅ Load CSS File
    $stylesheet = file_get_contents(
        FCPATH . 'assets/css/invoice.css'
    );

    // ✅ Apply CSS
    $mpdf->WriteHTML($stylesheet, 1);

    // ✅ Write HTML
    $mpdf->WriteHTML($html, 2);

    // ✅ Download PDF
    $mpdf->Output(
        'Invoice_' . $order_id . '.pdf',
        'D'
    );
}
//report api filter by date range and order status today
/*
public function sales_report()
{
    header('Content-Type: application/json');

    $start_date = $this->input->post('start_date');
    $end_date   = $this->input->post('end_date');
    $status     = $this->input->post('status');

    // ✅ Validate dates
    if (empty($start_date) || empty($end_date)) {
        echo json_encode([
            'status' => false,
            'message' => 'Start date and end date are required'
        ]);
        return;
    }

    // ✅ Build query
    $this->db->select('*');
    $this->db->from('order_tbl');
    $this->db->where('DATE(created_at) >=', $start_date);
    $this->db->where('DATE(created_at) <=', $end_date);

    if (!empty($status)) {
        $this->db->where('order_status', $status);
    }

    $report_data = $this->db->get()->result();

    echo json_encode([
        'status' => true,
        'data' => $report_data
    ]);
}



public function sales_report_today()
{
    header('Content-Type: application/json');

    $today = date('Y-m-d');

    $this->db->select('*');
    $this->db->from('order_tbl');
    $this->db->where('DATE(created_at)', $today);

    $report_data = $this->db->get()->result();

    $count = count($report_data);

    echo json_encode([
        'status' => true,
        'data' => $report_data,
        'count' => $count
    ]);
}

//report api filter by date range and order status today

public function sales_report_by_status()
{
    header('Content-Type: application/json');

    $status = $this->input->post('status');

    if (empty($status)) {
        echo json_encode([
            'status' => false,
            'message' => 'Order status is required'
        ]);
        return;
    }

    $this->db->select('*');
    $this->db->from('order_tbl');
    $this->db->where('order_status', $status);

    $report_data = $this->db->get()->result();

    echo json_encode([
        'status' => true,
        'data' => $report_data
    ]);

}
*/
/*
public function sales_report_by_today()
{
    header('Content-Type: application/json');

    $today = date('Y-m-d');
    $status = $this->input->post('status');

 
   /* $this->db->select('*');
    $this->db->from('order_tbl');
    $this->db->where('DATE(created_at)', $today);
    $this->db->where('order_status', $status);*/

    //$report_data = $this->db->get()->result();

  /*  $report_data=$this->input->Order_model->get_sales_report_by_today($today,$status);

    if(empty($report_data)){
        echo json_encode([
            'status' => false,
            'message' => 'No orders found for today with status: '.$status
        ]);
    }else{
        echo json_encode([
            'status' => true,
            'data' => $report_data
        ]);

    }
}
*/
/*
public function sales_report_by_today()
{
    header('Content-Type: application/json');

    $today = date('Y-m-d');

    $status = $this->input->post('order_status');



  //  echo $status; exit;
    if (empty($status)) {
        $status = 'all';
    }

   
    $report_data = $this->Order_model->get_by_kpis($today, $status);

    echo json_encode([
        'status' => true,
        'data' => $report_data
    ]);
}
*/
/*
public function sales_report_by_today()
{
    header('Content-Type: application/json');

    $today = date('Y-m-d');

    $status = $this->input->post('order_status');

   // echo $status;
    //exit;

    if (empty($status)) {
        $status = 'all';
    }

    $report_data = $this->Order_model->get_by_kpis($today, $status);

    $table_data = $this->Order_model->get_sales_report_by_today($today, $status);

    echo json_encode([
        'status' => true,
        'data' => $report_data
    ]);
}
*/

public function sales_report_by_today()
{
    header('Content-Type: application/json');

    $today = date('Y-m-d');

    $status = $this->input->post('order_status');

    if (empty($status)) {
        $status = 'all';
    }

    // KPI Cards Data
    $report_data = $this->Order_model->get_by_kpis($today, $status);

    // Table Data
    $table_data = $this->Order_model->get_sales_report_by_today($today, $status);

    echo json_encode([
        'status'     => true,
        'kpis'       => $report_data,
        'table_data' => $table_data
    ]);
}


// sales report by last 7 days

public function sales_report_by_last_7_days()
{
    header('Content-Type: application/json');

    $status = $this->input->post('order_status');

   // $days_ago = date('Y-m-d', strtotime('-7 days'));

    $start_date = date('Y-m-d', strtotime('-7 days'));
    $end_date = date('Y-m-d');

    if (empty($status)) {
        $status = 'all';
    }

    // KPI Cards Data
    $report_data = $this->Order_model->get_by_kpis($start_date,$end_date, $status);

    // Table Data
    $table_data = $this->Order_model->get_sales_report_by_last_7_days($start_date, $end_date, $status);

    echo json_encode([
        'status'     => true,
        'kpis'       => $report_data,
        'table_data' => $table_data
    ]);
    

}

//sales report by this month


public function sales_report_by_this_month()
{
    header('Content-Type: application/json');

    $status = $this->input->post('order_status');

    $start_date = date('Y-m-01'); // Returns the 1st day of the current month
    $end_date   = date('Y-m-t');  // Returns the last day of the current month

    if (empty($status)) {
        $status = 'all';
    }

    // KPI Cards Data
    $report_data = $this->Order_model->get_by_kpis($start_date,$end_date, $status);

    // Table Data
    $table_data = $this->Order_model->get_sales_report_by_this_month($start_date, $end_date, $status);

    echo json_encode([
        'status'     => true,
        'kpis'       => $report_data,
        'table_data' => $table_data
    ]);
}

//sales report by custom date range

public function sales_report_by_custom_date_range()
{
    header('Content-Type: application/json');

    $status = $this->input->post('order_status');
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');

    if (empty($status)) {
        $status = 'all';
    }

    // KPI Cards Data
    $report_data = $this->Order_model->get_by_kpis($start_date,$end_date, $status);

    // Table Data
    $table_data = $this->Order_model->get_sales_report_by_custom_date_range($start_date, $end_date, $status);

    echo json_encode([
        'status'     => true,
        'kpis'       => $report_data,
        'table_data' => $table_data
    ]);



}

public function sales_report()
{
    header('Content-Type: application/json');

    $status      = $this->input->post('order_status');
    $date_range  = $this->input->post('date_range');

    if (empty($status)) {
        $status = 'all';
    }

    // Default dates
    $start_date = '';
    $end_date   = '';

    // Today
    if ($date_range == 'today') {

        $start_date = date('Y-m-d');
        $end_date   = date('Y-m-d');

    }


    // Last 7 Days
else if ($date_range == 'week') {

    // Today 
    $start_date = date(
        'Y-m-d',
        strtotime('-6 days')
    );
  //  echo $start_date;

    //echo '<br>';

    $end_date = date('Y-m-d');

//    echo $end_date;

}

    // This Month
    else if ($date_range == 'month') {

        $start_date = date('Y-m-01');
        $end_date   = date('Y-m-t');

    }

    // Custom Range
    else if ($date_range == 'custom') {

        $start_date = $this->input->post('start_date');
        $end_date   = $this->input->post('end_date');

    }

    // KPI Cards Data
    $report_data = $this->Order_model->get_by_kpis(
        $start_date,
        $end_date,
        $status
    );

    // Table Data
    $table_data = $this->Order_model->get_sales_report(
        $start_date,
        $end_date,
        $status
    );

    echo json_encode([
        'status'     => true,
        'kpis'       => $report_data,
        'table_data' => $table_data
    ]);
}



//test
/*
public function test_excel()
{
    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

    $excel = new PHPExcel();

    $excel->setActiveSheetIndex(0);
    $excel->getActiveSheet()->setCellValue('A1', 'Excel Working');

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="test.xls"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $writer->save('php://output');

    exit;
}*/
  /*public function test_excel()
    {
        echo "working";
    }*/

        public function test_excel()
{
    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

    $excel = new PHPExcel();

    $excel->setActiveSheetIndex(0);
    $excel->getActiveSheet()->setCellValue('A1', 'Excel Working');

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="test.xls"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $writer->save('php://output');

    exit;
}
/*
public function export_excel()
{
    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Cell/DataType.php';

    $excel = new PHPExcel();

    $sheet = $excel->setActiveSheetIndex(0);

    // Header
   $sheet->setCellValue('A1', 'DATE');
    $sheet->setCellValue('B1', 'ORDERS');
    $sheet->setCellValue('C1', 'ITEMS');
    $sheet->setCellValue('D1', 'GROSS SALES');
    $sheet->setCellValue('E1', 'DISCOUNT');
    $sheet->setCellValue('F1', 'NET SALES');
    $sheet->setCellValue('G1', 'Website');
    // Bold header
    $sheet->getStyle('A1:G1')->getFont()->setBold(true);

    // Dynamic database data
   //$report = $this->db->get('sales_report')->result_array();

   $report = $this->Order_model->get_sales_report_excel();
  // $report = $this->db->get('order_tbl')->result_array();
    $row = 2;

    // Total variables
    $total_orders = 0;
    $total_items = 0;
    $total_gross = 0;
    $total_discount = 0;
    $total_net = 0;

//    foreach ($report as $data) {

      /*  $sheet->setCellValue('A'.$row, $data['date']);
        $sheet->setCellValue('B'.$row, $data['orders']);
        $sheet->setCellValue('C'.$row, $data['items']);
        $sheet->setCellValue('D'.$row, $data['gross_sales']);
        $sheet->setCellValue('E'.$row, $data['discount']);
        $sheet->setCellValue('F'.$row, $data['net_sales']);
        $sheet->setCellValue('G'.$row, $data['channel']);*/

     /*   $sheet->setCellValue('A'.$row, $data['date']);
        $sheet->setCellValue('B'.$row, (string)$data['orders']);
        $sheet->setCellValue('C'.$row, (string)$data['items']);
        $sheet->setCellValue('D'.$row, (string)$data['gross_sales']);
        $sheet->setCellValue('E'.$row, (string)$data['discount']);
        $sheet->setCellValue('F'.$row, (string)$data['net_sales']);
        $sheet->setCellValue('G'.$row, 'Website');

        // Add totals
        $total_orders += $data['orders'];
        $total_items += $data['items'];
        $total_gross += $data['gross_sales'];
        $total_discount += $data['discount'];
        $total_net += $data['net_sales'];

        $row++;
    }*/

    /*    foreach ($report as $data) {

    $sheet->setCellValueExplicit(
        'A'.$row,
        (string)$data['date'],
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'B'.$row,
        (string)$data['orders'],
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'C'.$row,
        (string)$data['items'],
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'D'.$row,
        (string)$data['gross_sales'],
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'E'.$row,
        (string)$data['discount'],
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'F'.$row,
        (string)$data['net_sales'],
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'G'.$row,
        'Website',
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    // totals
    $total_orders += (int)$data['orders'];
    $total_items += (int)$data['items'];
    $total_gross += (float)$data['gross_sales'];
    $total_discount += (float)$data['discount'];
    $total_net += (float)$data['net_sales'];

    $row++;
}

    // Totals row
    $sheet->setCellValue('A'.$row, 'TOTAL');
    $sheet->setCellValue('B'.$row, $total_orders);
    $sheet->setCellValue('C'.$row, $total_items);
    $sheet->setCellValue('D'.$row, $total_gross);
    $sheet->setCellValue('E'.$row, $total_discount);
    $sheet->setCellValue('F'.$row, $total_net);

    // Bold totals row
    $sheet->getStyle('A'.$row.':F'.$row)->getFont()->setBold(true);

    // Auto width
    foreach(range('A','G') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="sales_report.xls"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $writer->save('php://output');

    exit;
}
*/

public function export_excel()
{
    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Cell/DataType.php';

    $excel = new PHPExcel();

    $sheet = $excel->setActiveSheetIndex(0);

    $date_range = $this->input->get('date_range');
    $order_status = $this->input->get('order_status');

    // Header
    $sheet->setCellValue('A1', 'DATE');
    $sheet->setCellValue('B1', 'ORDERS');
    $sheet->setCellValue('C1', 'ITEMS');
    $sheet->setCellValue('D1', 'GROSS SALES');
    $sheet->setCellValue('E1', 'DISCOUNT');
    $sheet->setCellValue('F1', 'NET SALES');
    $sheet->setCellValue('G1', 'CHANNEL');

    // Header bold
    $sheet->getStyle('A1:G1')->getFont()->setBold(true);

    // Dynamic data
    $report = $this->Order_model->get_sales_report_excel( $date_range,$order_status);

    // Starting row
    $row = 2;

    // Totals
    $total_orders = 0;
    $total_items = 0;
    $total_gross = 0;
    $total_discount = 0;
    $total_net = 0;

    foreach ($report as $data) {

        $sheet->setCellValueExplicit(
            'A'.$row,
            (string)$data['date'],
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'B'.$row,
            (string)$data['orders'],
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'C'.$row,
            (string)$data['items'],
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'D'.$row,
            (string)$data['gross_sales'],
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'E'.$row,
            (string)$data['discount'],
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'F'.$row,
            (string)$data['net_sales'],
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'G'.$row,
            'Website',
            PHPExcel_Cell_DataType::TYPE_STRING
        );

        // Totals
        $total_orders += (int)$data['orders'];
        $total_items += (int)$data['items'];
        $total_gross += (float)$data['gross_sales'];
        $total_discount += (float)$data['discount'];
        $total_net += (float)$data['net_sales'];

        $row++;
    }

    // Totals row
    $sheet->setCellValueExplicit(
        'A'.$row,
        'TOTAL',
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'B'.$row,
        (string)$total_orders,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'C'.$row,
        (string)$total_items,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'D'.$row,
        (string)$total_gross,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'E'.$row,
        (string)$total_discount,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'F'.$row,
        (string)$total_net,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    // Bold totals row
    $sheet->getStyle('A'.$row.':F'.$row)->getFont()->setBold(true);

    // Auto width
    foreach (range('A', 'G') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // File download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="sales_report.xls"');
    header('Cache-Control: max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $writer->save('php://output');

    exit;
}
/*

public function download_pdf()
{
    // Load mPDF
    require_once APPPATH . 'third_party/mpdf/vendor/autoload.php';

    // Filters
    $date_range = $this->input->get('date_range');
    $order_status = $this->input->get('order_status');

    // Get filtered report data
    $report = $this->Order_model->get_sales_report_excel(
        $date_range,
        $order_status
    );

    // Totals
    $total_orders = 0;
    $total_items = 0;
    $total_gross = 0;
    $total_discount = 0;
    $total_net = 0;

    // HTML
    $html = '
    <h2 style="text-align:center;">
        Sales Report
    </h2>

    <table border="1" cellpadding="8" width="100%">
        <thead>
            <tr style="background:#f2f2f2;">
                <th>DATE</th>
                <th>ORDERS</th>
                <th>ITEMS</th>
                <th>GROSS SALES</th>
                <th>DISCOUNT</th>
                <th>NET SALES</th>
                <th>CHANNEL</th>
            </tr>
        </thead>
        <tbody>
    ';

    foreach ($report as $row) {

        $html .= '
        <tr>
            <td>'.$row['date'].'</td>
            <td>'.$row['orders'].'</td>
            <td>'.$row['items'].'</td>
            <td>₹'.$row['gross_sales'].'</td>
            <td>₹'.$row['discount'].'</td>
            <td>₹'.$row['net_sales'].'</td>
            <td>Website</td>
        </tr>
        ';

        // Totals
        $total_orders += (int)$row['orders'];
        $total_items += (int)$row['items'];
        $total_gross += (float)$row['gross_sales'];
        $total_discount += (float)$row['discount'];
        $total_net += (float)$row['net_sales'];
    }

    // Totals row
    $html .= '
        <tr style="font-weight:bold;background:#f2f2f2;">
            <td>TOTAL</td>
            <td>'.$total_orders.'</td>
            <td>'.$total_items.'</td>
            <td>₹'.$total_gross.'</td>
            <td>₹'.$total_discount.'</td>
            <td>₹'.$total_net.'</td>
            <td></td>
        </tr>
    ';

    $html .= '
        </tbody>
    </table>
    ';

    // Generate PDF
    $mpdf = new \Mpdf\Mpdf();

    $mpdf->WriteHTML($html);

    // Download PDF
    $mpdf->Output(
        'sales_report.pdf',
        'D'
    );
}
    */

public function download_pdf()
{
    // Filters
    $date_range = $this->input->get('date_range');

    $order_status = $this->input->get('order_status');

    // Report Data
    $data['report'] = $this->Order_model->get_sales_report_excel(
        $date_range,
        $order_status
    );

    // Totals
    $data['total_orders'] = 0;
    $data['total_items'] = 0;
    $data['total_gross'] = 0;
    $data['total_discount'] = 0;
    $data['total_net'] = 0;

    foreach ($data['report'] as $row) {

        $data['total_orders'] += (int)$row['orders'];

        $data['total_items'] += (int)$row['items'];

        $data['total_gross'] += (float)$row['gross_sales'];

        $data['total_discount'] += (float)$row['discount'];

        $data['total_net'] += (float)$row['net_sales'];
    }

    
                // Report Heading

            $report_heading = 'Sales Report';

            if ($date_range == 'today') {

                $report_heading =
                    'Today Sales Report - ' .
                    date('d M Y');

            }

            else if ($date_range == 'week') {

                $report_heading =
                    'Last 7 Days Sales Report';

            }

            else if ($date_range == 'month') {

                $report_heading =
                    'This Month Sales Report - ' .
                    date('F Y');

            }

            else if ($date_range == 'custom') {

                $start_date = $this->input->get('start_date');

                $end_date = $this->input->get('end_date');

                $report_heading =
                    'Custom Sales Report (' .
                    date('d M Y', strtotime($start_date))
                    . ' to ' .
                    date('d M Y', strtotime($end_date))
                    . ')';
            }

    // PDF HTML View
    $html = '

    <h2 style="text-align:center;">
         '.$report_heading.'
    </h2>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">

        <thead>

            <tr style="background:#f2f2f2;">

                <th>DATE</th>

                <th>ORDERS</th>

                <th>ITEMS</th>

                <th>GROSS SALES</th>

                <th>DISCOUNT</th>

                <th>NET SALES</th>

                <th>CHANNEL</th>

            </tr>

        </thead>

        <tbody>
    ';

    foreach ($data['report'] as $row) {

        $html .= '

        <tr>

            <td>'.$row['date'].'</td>

            <td>'.$row['orders'].'</td>

            <td>'.$row['items'].'</td>

            <td>₹'.$row['gross_sales'].'</td>

            <td>₹'.$row['discount'].'</td>

            <td>₹'.$row['net_sales'].'</td>

            <td>Website</td>

        </tr>
        ';
    }


    // Totals Row
    $html .= '

        <tr style="font-weight:bold;background:#f2f2f2;">

            <td>TOTAL</td>

            <td>'.$data['total_orders'].'</td>

            <td>'.$data['total_items'].'</td>

            <td>₹'.$data['total_gross'].'</td>

            <td>₹'.$data['total_discount'].'</td>

            <td>₹'.$data['total_net'].'</td>

            <td></td>

        </tr>

        </tbody>

    </table>
    ';

    // mPDF
    $mpdf = new \Mpdf\Mpdf();

    $mpdf->WriteHTML($html);

    // Download PDF
    $mpdf->Output(
        'sales_report.pdf',
        'D'
    );
}

//gst sales summary by date range


public function gst_sales_summary()
{
    header('Content-Type: application/json');

    $date_range = $this->input->get('date_range');

    $start_date = $this->input->get('start_date');

    $end_date = $this->input->get('end_date');



    // Get data from model
    $report = $this->Order_model->get_gst_sales_summary( $date_range, $start_date, $end_date );
    

    // Summary
    $taxable = 0;
    $gst = 0;
    $grand = 0;

    foreach ($report as $row) {

        $taxable += $row['sub_total'];

        $gst += $row['tax'];

        $grand += $row['grand_total'];
    }

    echo json_encode([

        'status' => true,

        'summary' => [

            'taxable_value' => round($taxable, 2),

            'total_gst' => round($gst, 2),

            'grand_total' => round($grand, 2),
        ],

        'data' => $report
    ]);
}


//pdf download of gst sales summary

/*
public function download_gst_pdf()
{

    // FILTERS
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');


        

    // LOAD MODEL
    $this->load->model('admin/Order_model');


    // DATE RANGE LABEL
$range_label = '';

if ($date_range == 'today') {

    $range_label = 'Today';

} elseif ($date_range == 'week') {

    $range_label = 'Last 7 Days';

} elseif ($date_range == 'month') {

    $range_label = 'This Month';

} elseif ($date_range == 'custom') {

    $range_label =
        'Custom Range : ' .
        date(
            'd-m-Y',
            strtotime($start_date)
        ) .
        ' To ' .
        date(
            'd-m-Y',
            strtotime($end_date)
        );

} else {

    $range_label = 'All';
}

    // REPORT DATA
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // TOTAL VARIABLES
    $total_taxable = 0;

    $total_gst = 0;

    $final_total = 0;

    // HTML START
    $html = '

    <style>

        body{
            font-family: sans-serif;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#f2f2f2;
            font-weight:bold;
            text-align:center;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
            font-size:12px;
        }

    </style>

   <h2>
    GST Sales Summary
</h2>

<p style="
    text-align:center;
    font-size:14px;
    margin-bottom:20px;">

    <strong>Date Range :</strong>

    ' . $range_label . '

</p>

    <table>

        <thead>

            <tr>

                <th>Invoice</th>

                <th>Date</th>

                <th>Customer</th>

                <th>State</th>

                <th>Taxable</th>

                <th>GST</th>

                <th>Total</th>

            </tr>

        </thead>

        <tbody>
    ';

    // CHECK DATA
    if (!empty($report)) {

        foreach ($report as $row) {

            // TOTALS
            $total_taxable +=
                (float)$row['sub_total'];

            $total_gst +=
                (float)$row['tax'];

            $final_total +=
                (float)$row['grand_total'];

            $html .= '

            <tr>

                <td>
                    ' . $row['invoice_no'] . '
                </td>

                <td>
                    ' . date(
                        'd-m-Y',
                        strtotime(
                            $row['invoice_date']
                        )
                    ) . '
                </td>

                <td>
                    ' . $row['customer_name'] . '
                </td>

                <td>
                    ' . $row['state'] . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['sub_total'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['tax'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['grand_total'],
                        2
                    ) . '
                </td>

            </tr>
            ';
        }

        // GRAND TOTAL ROW
        $html .= '

        <tr>

            <td colspan="4"
                style="
                font-weight:bold;
                text-align:right;
                background:#f2f2f2;">

                GRAND TOTAL

            </td>

            <td style="
                font-weight:bold;
                background:#f2f2f2;">

                ₹' . number_format(
                    $total_taxable,
                    2
                ) . '

            </td>

            <td style="
                font-weight:bold;
                background:#f2f2f2;">

                ₹' . number_format(
                    $total_gst,
                    2
                ) . '

            </td>

            <td style="
                font-weight:bold;
                background:#f2f2f2;">

                ₹' . number_format(
                    $final_total,
                    2
                ) . '

            </td>

        </tr>
        ';

    } else {

        $html .= '

        <tr>

            <td colspan="7"
                style="text-align:center;">

                No Records Found

            </td>

        </tr>
        ';
    }

    $html .= '

        </tbody>

    </table>
    ';

    // MPDF
    require_once APPPATH .
        '../vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([

        'format' => 'A4-L'
    ]);

    $mpdf->WriteHTML($html);

    // DOWNLOAD PDF
    $mpdf->Output(
        'gst_sales_summary.pdf',
        'D'
    );
}
*/


public function download_gst_pdf()
{

    // FILTERS
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // LOAD MODEL
    $this->load->model('admin/Order_model');

    // REPORT DATA
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // REPORT HEADING
    $report_heading =
        'GST Sales Summary';

    if ($date_range == 'today') {

        $report_heading =
            'Today GST Sales Summary - ' .
            date('d M Y');
    }

    else if ($date_range == 'week') {

        $report_heading =
            'Last 7 Days GST Sales Summary';
    }

    else if ($date_range == 'month') {

        $report_heading =
            'This Month GST Sales Summary - ' .
            date('F Y');
    }

    else if ($date_range == 'custom') {

        $report_heading =
            'Custom GST Sales Summary (' .

            date(
                'd M Y',
                strtotime($start_date)
            )

            . ' to ' .

            date(
                'd M Y',
                strtotime($end_date)
            )

            . ')';
    }

    // TOTAL VARIABLES
    $total_taxable = 0;

    $total_gst = 0;

    $final_total = 0;

    // HTML START
    $html = '

    <style>

        body{
            font-family: sans-serif;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#f2f2f2;
            font-weight:bold;
            text-align:center;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
            font-size:12px;
        }

    </style>

    <h2>
        ' . $report_heading . '
    </h2>

    <table>

        <thead>

            <tr>

                <th>Invoice</th>

                <th>Date</th>

                <th>Customer</th>

                <th>State</th>

                <th>Taxable</th>

                <th>GST</th>

                <th>Total</th>

            </tr>

        </thead>

        <tbody>
    ';

    // CHECK DATA
    if (!empty($report)) {

        foreach ($report as $row) {

            // TOTALS
            $total_taxable +=
                (float)$row['sub_total'];

            $total_gst +=
                (float)$row['tax'];

            $final_total +=
                (float)$row['grand_total'];

            $html .= '

            <tr>

                <td>
                    ' . $row['invoice_no'] . '
                </td>

                <td>
                    ' . date(
                        'd-m-Y',
                        strtotime(
                            $row['invoice_date']
                        )
                    ) . '
                </td>

                <td>
                    ' . $row['customer_name'] . '
                </td>

                <td>
                    ' . $row['state'] . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['sub_total'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['tax'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['grand_total'],
                        2
                    ) . '
                </td>

            </tr>
            ';
        }

        // GRAND TOTAL ROW
        $html .= '

        <tr>

            <td colspan="4"
                style="
                font-weight:bold;
                text-align:right;
                background:#f2f2f2;">

                GRAND TOTAL

            </td>

            <td style="
                font-weight:bold;
                background:#f2f2f2;">

                ₹' . number_format(
                    $total_taxable,
                    2
                ) . '

            </td>

            <td style="
                font-weight:bold;
                background:#f2f2f2;">

                ₹' . number_format(
                    $total_gst,
                    2
                ) . '

            </td>

            <td style="
                font-weight:bold;
                background:#f2f2f2;">

                ₹' . number_format(
                    $final_total,
                    2
                ) . '

            </td>

        </tr>
        ';
    }

    else {

        $html .= '

        <tr>

            <td colspan="7"
                style="text-align:center;">

                No Records Found

            </td>

        </tr>
        ';
    }

    $html .= '

        </tbody>

    </table>
    ';

    // MPDF
    require_once APPPATH .
        '../vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([

        'format' => 'A4-L'
    ]);

    $mpdf->WriteHTML($html);

    // DOWNLOAD PDF
    $mpdf->Output(
        'gst_sales_summary.pdf',
        'D'
    );
}
/*
public function download_gst_pdf()
{

    // Filters
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // Load Model
    $this->load->model('admin/Order_model');

    // Filtered Report Data
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // HTML START
    $html = '

    <style>

        body{
            font-family: sans-serif;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#f2f2f2;
            font-weight:bold;
            text-align:center;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
            font-size:12px;
        }

    </style>

    <h2>
        GST Sales Summary
    </h2>

    <table>

        <thead>

            <tr>

                <th>Invoice</th>

                <th>Date</th>

                <th>Customer</th>

                <th>State</th>

                <th>Taxable</th>

                <th>GST</th>

                <th>Total</th>

            </tr>

        </thead>

        <tbody>
    ';

    // CHECK DATA
    if (!empty($report)) {

        foreach ($report as $row) {

            $html .= '

            <tr>

                <td>
                    ' . $row['invoice_no'] . '
                </td>

                <td>
                    ' . date(
                        'd-m-Y',
                        strtotime(
                            $row['invoice_date']
                        )
                    ) . '
                </td>

                <td>
                    ' . $row['customer_name'] . '
                </td>

                <td>
                    ' . $row['state'] . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['sub_total'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['tax'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['grand_total'],
                        2
                    ) . '
                </td>

            </tr>
            ';
        }

    } else {

        $html .= '

        <tr>

            <td colspan="7"
                style="text-align:center;">

                No Records Found

            </td>

        </tr>
        ';
    }

    $html .= '

        </tbody>

    </table>
    ';

    // MPDF
    require_once APPPATH .
        '../vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([

        'format' => 'A4-L'
    ]);

    $mpdf->WriteHTML($html);

    // DOWNLOAD PDF
    $mpdf->Output(
        'gst_sales_summary.pdf',
        'D'
    );
}*/
/*

public function export_gst_excel()
{

    // Filters
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // Load Model
    $this->load->model('admin/Order_model');

    // Report Data
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // File Name
    $filename =
        "gst_sales_summary.xls";

    // Headers
    header(
        "Content-Type: application/vnd.ms-excel"
    );

    header(
        "Content-Disposition: attachment; filename=$filename"
    );

    // Grand Total Variable
    $final_total = 0;

    echo '

    <table border="1">

        <tr>

            <th colspan="7"
                style="font-size:18px;
                background:#f2f2f2;">

                GST Sales Summary

            </th>

        </tr>

        <tr>

            <th>Invoice</th>

            <th>Date</th>

            <th>Customer</th>

            <th>State</th>

            <th>Taxable</th>

            <th>GST</th>

            <th>Total</th>

        </tr>
    ';

    if (!empty($report)) {

        foreach ($report as $row) {

            $final_total +=
                $row['grand_total'];

            echo '

            <tr>

                <td>
                    ' . $row['invoice_no'] . '
                </td>

                <td>
                    ' . date(
                        'd-m-Y',
                        strtotime(
                            $row['invoice_date']
                        )
                    ) . '
                </td>

                <td>
                    ' . $row['customer_name'] . '
                </td>

                <td>
                    ' . $row['state'] . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['sub_total'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['tax'],
                        2
                    ) . '
                </td>

                <td>
                    ₹' . number_format(
                        $row['grand_total'],
                        2
                    ) . '
                </td>

            </tr>
            ';
        }

        // FINAL GRAND TOTAL ROW
        echo '

        <tr>

            <td colspan="6"
                style="
                font-weight:bold;
                text-align:right;
                background:#f2f2f2;">

                Final Grand Total

            </td>

            <td
                style="
                font-weight:bold;
                background:#f2f2f2;">

                ₹' . number_format(
                    $final_total,
                    2
                ) . '

            </td>

        </tr>
        ';

    } else {

        echo '

        <tr>

            <td colspan="7"
                style="text-align:center;">

                No Records Found

            </td>

        </tr>
        ';
    }

    echo '</table>';

    exit;
}

*/

/*
public function export_gst_excel()
{

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel.php';

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel/Cell/DataType.php';

    $excel = new PHPExcel();

    $sheet =
        $excel->setActiveSheetIndex(0);

    // Filters
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // Report Data
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // Title
    $sheet->setCellValue(
        'A1',
        'GST Sales Summary'
    );

    // Merge Title
    $sheet->mergeCells('A1:G1');

    // Bold Title
    $sheet->getStyle('A1')
        ->getFont()
        ->setBold(true);

    // Center Title
    $sheet->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(
            PHPExcel_Style_Alignment
                ::HORIZONTAL_CENTER
        );

    // Headers
    $sheet->setCellValue('A3', 'Invoice');
    $sheet->setCellValue('B3', 'Date');
    $sheet->setCellValue('C3', 'Customer');
    $sheet->setCellValue('D3', 'State');
    $sheet->setCellValue('E3', 'Taxable');
    $sheet->setCellValue('F3', 'GST');
    $sheet->setCellValue('G3', 'Total');

    // Header Bold
    $sheet->getStyle('A3:G3')
        ->getFont()
        ->setBold(true);

    // Start Row
    $row = 4;

    // Final Grand Total
    $final_total = 0;

    // Data
    foreach ($report as $data) {

        $sheet->setCellValueExplicit(
            'A' . $row,
            (string)$data['invoice_no'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'B' . $row,
            date(
                'd-m-Y',
                strtotime(
                    $data['invoice_date']
                )
            ),
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'C' . $row,
            (string)$data['customer_name'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'D' . $row,
            (string)$data['state'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'E' . $row,
            (string)$data['sub_total'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'F' . $row,
            (string)$data['tax'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'G' . $row,
            (string)$data['grand_total'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        // Add Grand Total
        $final_total +=
            (float)$data['grand_total'];

        $row++;
    }

    // FINAL TOTAL ROW
    $sheet->setCellValue(
        'F' . $row,
        'Final Grand Total'
    );

    $sheet->setCellValue(
        'G' . $row,
        $final_total
    );

    // Bold Final Row
    $sheet->getStyle(
        'F' . $row . ':G' . $row
    )->getFont()->setBold(true);

    // Auto Width
    foreach (range('A', 'G') as $column) {

        $sheet->getColumnDimension(
            $column
        )->setAutoSize(true);
    }

    // File Download
    header(
        'Content-Type: application/vnd.ms-excel'
    );

    header(
        'Content-Disposition: attachment;filename="gst_sales_summary.xls"'
    );

    header(
        'Cache-Control: max-age=0'
    );

    $writer =
        PHPExcel_IOFactory
            ::createWriter(
                $excel,
                'Excel5'
            );

    $writer->save('php://output');

    exit;
}
*/


/*
public function export_gst_excel()
{

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel.php';

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel/Cell/DataType.php';

    $excel = new PHPExcel();

    $sheet =
        $excel->setActiveSheetIndex(0);

    // Filters
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // Report Data
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // Title
    $sheet->setCellValue(
        'A1',
        'GST Sales Summary'
    );

    // Merge Title
    $sheet->mergeCells('A1:G1');

    // Bold Title
    $sheet->getStyle('A1')
        ->getFont()
        ->setBold(true);

    // Center Title
    $sheet->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(
            PHPExcel_Style_Alignment
                ::HORIZONTAL_CENTER
        );

    // Headers
    $sheet->setCellValue('A3', 'Invoice');
    $sheet->setCellValue('B3', 'Date');
    $sheet->setCellValue('C3', 'Customer');
    $sheet->setCellValue('D3', 'State');
    $sheet->setCellValue('E3', 'Taxable');
    $sheet->setCellValue('F3', 'GST');
    $sheet->setCellValue('G3', 'Total');

    // Header Bold
    $sheet->getStyle('A3:G3')
        ->getFont()
        ->setBold(true);

    // Start Row
    $row = 4;

    // Final Grand Total
    $final_total = 0;

    // Data
    foreach ($report as $data) {

        $sheet->setCellValueExplicit(
            'A' . $row,
            (string)$data['invoice_no'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'B' . $row,
            date(
                'd-m-Y',
                strtotime(
                    $data['invoice_date']
                )
            ),
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'C' . $row,
            (string)$data['customer_name'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'D' . $row,
            (string)$data['state'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        // NUMERIC VALUES
        $sheet->setCellValue(
            'E' . $row,
            $data['sub_total']
        );

        $sheet->setCellValue(
            'F' . $row,
            $data['tax']
        );

        $sheet->setCellValue(
            'G' . $row,
            $data['grand_total']
        );

        // Add Grand Total
        $final_total +=
            (float)$data['grand_total'];

        $row++;
    }

    // FINAL TOTAL ROW
    $sheet->setCellValue(
        'F' . $row,
        'Final Grand Total'
    );

    $sheet->setCellValueExplicit(
        'G' . $row,
        (string)$final_total,
        PHPExcel_Cell_DataType
            ::TYPE_STRING
    );

    // Bold Final Row
    $sheet->getStyle(
        'F' . $row . ':G' . $row
    )->getFont()->setBold(true);

    // Auto Width
    foreach (range('A', 'G') as $column) {

        $sheet->getColumnDimension(
            $column
        )->setAutoSize(true);
    }

    // File Download
    header(
        'Content-Type: application/vnd.ms-excel'
    );

    header(
        'Content-Disposition: attachment;filename="gst_sales_summary.xls"'
    );

    header(
        'Cache-Control: max-age=0'
    );

    $writer =
        PHPExcel_IOFactory
            ::createWriter(
                $excel,
                'Excel5'
            );

    $writer->save('php://output');

    exit;
}

*/

/*
public function export_gst_excel()
{

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel.php';

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel/Cell/DataType.php';

    $excel = new PHPExcel();

    $sheet =
        $excel->setActiveSheetIndex(0);

    // Filters
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // Report Data
    $report = $this->Order_model
        ->get_gst_sales_summary(
            $date_range,
            $start_date,
            $end_date
        );

    // TITLE
    $sheet->setCellValue(
        'A1',
        'GST Sales Summary'
    );

    // MERGE TITLE
    $sheet->mergeCells('A1:G1');

    // TITLE STYLE
    $sheet->getStyle('A1')
        ->getFont()
        ->setBold(true);

    $sheet->getStyle('A1')
        ->getFont()
        ->setSize(16);

    $sheet->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(
            PHPExcel_Style_Alignment
                ::HORIZONTAL_CENTER
        );

    // HEADERS
    $sheet->setCellValue('A3', 'Invoice');
    $sheet->setCellValue('B3', 'Date');
    $sheet->setCellValue('C3', 'Customer');
    $sheet->setCellValue('D3', 'State');
    $sheet->setCellValue('E3', 'Taxable');
    $sheet->setCellValue('F3', 'GST');
    $sheet->setCellValue('G3', 'Total');

    // HEADER BOLD
    $sheet->getStyle('A3:G3')
        ->getFont()
        ->setBold(true);

    // START ROW
    $row = 4;

    // TOTAL VARIABLES
    $total_taxable = 0;
    $total_gst = 0;
    $final_total = 0;

    // DATA
    foreach ($report as $data) {

        $sheet->setCellValueExplicit(
            'A' . $row,
            (string)$data['invoice_no'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'B' . $row,
            date(
                'd-m-Y',
                strtotime(
                    $data['invoice_date']
                )
            ),
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'C' . $row,
            (string)$data['customer_name'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValueExplicit(
            'D' . $row,
            (string)$data['state'],
            PHPExcel_Cell_DataType
                ::TYPE_STRING
        );

        $sheet->setCellValue(
            'E' . $row,
            $data['sub_total']
        );

        $sheet->setCellValue(
            'F' . $row,
            $data['tax']
        );

        $sheet->setCellValue(
            'G' . $row,
            $data['grand_total']
        );

        // TOTALS
        $total_taxable +=
            (float)$data['sub_total'];

        $total_gst +=
            (float)$data['tax'];

        $final_total +=
            (float)$data['grand_total'];

        $row++;
    }

    // FINAL TOTAL ROW
    $sheet->setCellValue(
        'D' . $row,
        'TOTAL'
    );

    $sheet->setCellValue(
        'E' . $row,
        $total_taxable
    );

    $sheet->setCellValue(
        'F' . $row,
        $total_gst
    );

    $sheet->setCellValue(
        'G' . $row,
        $final_total
    );

    // FINAL ROW STYLE
    $sheet->getStyle(
        'D' . $row . ':G' . $row
    )->getFont()->setBold(true);

    // AUTO WIDTH
    foreach (range('A', 'G') as $column) {

        $sheet->getColumnDimension(
            $column
        )->setAutoSize(true);
    }

    // FILE NAME
    $filename =
        "gst_sales_summary.xls";

    // DOWNLOAD HEADERS
    header(
        'Content-Type: application/vnd.ms-excel'
    );

    header(
        'Content-Disposition: attachment;filename="' . $filename . '"'
    );

    header(
        'Cache-Control: max-age=0'
    );

    // WRITER
    $writer =
        PHPExcel_IOFactory
            ::createWriter(
                $excel,
                'Excel5'
            );

    $writer->save('php://output');

    exit;


}
*/

public function export_gst_excel()
{
    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';

    require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Cell/DataType.php';

    $excel = new PHPExcel();

    $sheet = $excel->setActiveSheetIndex(0);

    // FILTERS
    $date_range = $this->input->get('date_range');

    $start_date = $this->input->get('start_date');

    $end_date = $this->input->get('end_date');

    // REPORT DATA
    $report = $this->Order_model->get_gst_sales_summary(
        $date_range,
        $start_date,
        $end_date
    );

    // TITLE
    $sheet->setCellValue('A1', 'GST Sales Summary');

    $sheet->mergeCells('A1:G1');

    $sheet->getStyle('A1')->getFont()->setBold(true);

    $sheet->getStyle('A1')->getFont()->setSize(16);

    $sheet->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(
            PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        );

    // HEADERS
    $sheet->setCellValue('A3', 'Invoice');
    $sheet->setCellValue('B3', 'Date');
    $sheet->setCellValue('C3', 'Customer');
    $sheet->setCellValue('D3', 'State');
    $sheet->setCellValue('E3', 'Taxable');
    $sheet->setCellValue('F3', 'GST');
    $sheet->setCellValue('G3', 'Total');

    // HEADER STYLE
    $sheet->getStyle('A3:G3')
        ->getFont()
        ->setBold(true);

    // START ROW
    $row = 4;

    // TOTALS
    $total_taxable = 0;

    $total_gst = 0;

    $final_total = 0;

    // DATA
    if (!empty($report)) {

        foreach ($report as $data) {

            $sheet->setCellValueExplicit(
                'A' . $row,
                (string)$data['invoice_no'],
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'B' . $row,
                date(
                    'd-m-Y',
                    strtotime($data['invoice_date'])
                ),
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'C' . $row,
                (string)$data['customer_name'],
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'D' . $row,
                (string)$data['state'],
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            // IMPORTANT FIX
            $sheet->setCellValueExplicit(
                'E' . $row,
                (string)$data['sub_total'],
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'F' . $row,
                (string)$data['tax'],
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            $sheet->setCellValueExplicit(
                'G' . $row,
                (string)$data['grand_total'],
                PHPExcel_Cell_DataType::TYPE_STRING
            );

            // TOTALS
            $total_taxable += (float)$data['sub_total'];

            $total_gst += (float)$data['tax'];

            $final_total += (float)$data['grand_total'];

            $row++;
        }
    }

    // TOTAL ROW
    $sheet->setCellValue(
        'D' . $row,
        'TOTAL'
    );

    $sheet->setCellValueExplicit(
        'E' . $row,
        (string)$total_taxable,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'F' . $row,
        (string)$total_gst,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'G' . $row,
        (string)$final_total,
        PHPExcel_Cell_DataType::TYPE_STRING
    );

    // TOTAL STYLE
    $sheet->getStyle(
        'D' . $row . ':G' . $row
    )->getFont()->setBold(true);

    // AUTO WIDTH
    foreach (range('A', 'G') as $column) {

        $sheet->getColumnDimension($column)
            ->setAutoSize(true);
    }

    // FILE NAME
    $filename = "gst_sales_summary.xls";

    // HEADERS
    header('Content-Type: application/vnd.ms-excel');

    header(
        'Content-Disposition: attachment;filename="' .
        $filename .
        '"'
    );

    header('Cache-Control: max-age=0');

    // WRITER
    $writer = PHPExcel_IOFactory::createWriter(
        $excel,
        'Excel5'
    );

    $writer->save('php://output');

    exit;
}

//statewise gst report
/*
public function statewise_gst_report()
{

    // Filters
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // Report Data
    $report = $this->Order_model
        ->get_statewise_gst_report(
            $date_range,
            $start_date,
            $end_date
        );

    // Return JSON Response
    echo json_encode($report);
}*/


public function statewise_gst_report()
{

    // FILTERS
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // LOAD MODEL
    $this->load->model('Order_model');

    // REPORT DATA
    $report =
        $this->Order_model
            ->get_statewise_gst_report(
                $date_range,
                $start_date,
                $end_date
            );

    // SUMMARY VARIABLES
    $taxable_value = 0;

    $cgst = 0;

    $sgst = 0;

    $igst = 0;

    // CALCULATE SUMMARY
    foreach ($report as $row) {

        $taxable_value +=
            (float)$row['sub_total'];

        $cgst +=
            (float)$row['tax'] / 2;

        $sgst +=
            (float)$row['tax'] / 2;

        // IGST FOR OTHER STATES
        if (
            strtolower(trim($row['state']))
            != 'maharashtra'
        ) {

            $igst +=
                (float)$row['tax'];
        }
    }

    // RESPONSE
    $response = array(

        'summary' => array(

            'taxable_value' =>
                '₹' . number_format(
                    $taxable_value,
                    2
                ),

            'cgst' =>
                '₹' . number_format(
                    $cgst,
                    2
                ),

            'sgst' =>
                '₹' . number_format(
                    $sgst,
                    2
                ),

            'igst' =>
                '₹' . number_format(
                    $igst,
                    2
                )
        ),

        'data' => $report
    );

    // JSON
    echo json_encode($response);
}


public function download_statewise_gst_pdf()
{

    // FILTERS
    $date_range = $this->input->get('date_range');

    $start_date = $this->input->get('start_date');

    $end_date = $this->input->get('end_date');

    // LOAD MODEL
    $this->load->model('Order_model');

    // REPORT DATA
    $report = $this->Order_model
        ->get_statewise_gst_report(
            $date_range,
            $start_date,
            $end_date
        );

    // TOTALS
    $total_taxable = 0;

    $total_gst = 0;

    $total_invoices = 0;

    // REPORT HEADING
    $report_heading = 'Statewise GST Report';

    if ($date_range == 'today') {

        $report_heading =
            'Today Statewise GST Report - ' .
            date('d M Y');

    } elseif ($date_range == 'week') {

        $report_heading =
            'Last 7 Days Statewise GST Report';

    } elseif ($date_range == 'month') {

        $report_heading =
            'This Month Statewise GST Report - ' .
            date('F Y');

    } elseif ($date_range == 'custom') {

        $report_heading =
            'Custom Statewise GST Report (' .
            date(
                'd M Y',
                strtotime($start_date)
            ) .
            ' to ' .
            date(
                'd M Y',
                strtotime($end_date)
            ) .
            ')';
    }

    // HTML
    $html = '

    <style>

        body{
            font-family:sans-serif;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
            font-size:12px;
        }

        table th{
            background:#f2f2f2;
        }

    </style>

    <h2>' . $report_heading . '</h2>

    <table>

        <thead>

            <tr>

                <th>STATE</th>

                <th>TAXABLE VALUE</th>

                <th>GST COLLECTED</th>

                <th>INVOICES</th>

            </tr>

        </thead>

        <tbody>
    ';

    if (!empty($report)) {

        foreach ($report as $row) {

            $total_taxable +=
                (float)$row['sub_total'];

            $total_gst +=
                (float)$row['tax'];

            $total_invoices +=
                (int)$row['invoices'];

            $html .= '

            <tr>

                <td>' . $row['state'] . '</td>

                <td>₹' .
                    number_format(
                        $row['sub_total'],
                        2
                    ) .
                '</td>

                <td>₹' .
                    number_format(
                        $row['tax'],
                        2
                    ) .
                '</td>

                <td>' .
                    $row['invoices'] .
                '</td>

            </tr>
            ';
        }

        // TOTAL ROW
        $html .= '

        <tr style="font-weight:bold;background:#f2f2f2;">

            <td>TOTAL</td>

            <td>₹' .
                number_format(
                    $total_taxable,
                    2
                ) .
            '</td>

            <td>₹' .
                number_format(
                    $total_gst,
                    2
                ) .
            '</td>

            <td>' .
                $total_invoices .
            '</td>

        </tr>
        ';
    }

    $html .= '

        </tbody>

    </table>
    ';

    require_once APPPATH .
        '../vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf();

    $mpdf->WriteHTML($html);

    $mpdf->Output(
        'statewise_gst_report.pdf',
        'D'
    );
}



public function export_statewise_gst_excel()
{

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel.php';

    require_once APPPATH .
        'third_party/PHPExcel/Classes/PHPExcel/Cell/DataType.php';

    $excel = new PHPExcel();

    $sheet =
        $excel->setActiveSheetIndex(0);

    // FILTERS
    $date_range =
        $this->input->get('date_range');

    $start_date =
        $this->input->get('start_date');

    $end_date =
        $this->input->get('end_date');

    // LOAD MODEL
    $this->load->model('Order_model');

    // REPORT DATA
    $report =
        $this->Order_model
            ->get_statewise_gst_report(
                $date_range,
                $start_date,
                $end_date
            );

    // TITLE
    $sheet->setCellValue(
        'A1',
        'Statewise GST Report'
    );

    // MERGE TITLE
    $sheet->mergeCells('A1:D1');

    // TITLE STYLE
    $sheet->getStyle('A1')
        ->getFont()
        ->setBold(true);

    $sheet->getStyle('A1')
        ->getFont()
        ->setSize(16);

    // CENTER TITLE
    $sheet->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(
            PHPExcel_Style_Alignment
                ::HORIZONTAL_CENTER
        );

    // HEADERS
    $sheet->setCellValue('A3', 'STATE');

    $sheet->setCellValue('B3', 'TAXABLE VALUE');

    $sheet->setCellValue('C3', 'GST COLLECTED');

    $sheet->setCellValue('D3', 'INVOICES');

    // HEADER STYLE
    $sheet->getStyle('A3:D3')
        ->getFont()
        ->setBold(true);

    // START ROW
    $row = 4;

    // TOTAL VARIABLES
    $total_taxable = 0;

    $total_gst = 0;

    $total_invoices = 0;

    // DATA LOOP
    if (!empty($report)) {

        foreach ($report as $data) {

            // STATE
            $sheet->setCellValueExplicit(
                'A' . $row,
                (string)$data['state'],
                PHPExcel_Cell_DataType
                    ::TYPE_STRING
            );

            // TAXABLE
            $sheet->setCellValueExplicit(
                'B' . $row,
                (string)$data['sub_total'],
                PHPExcel_Cell_DataType
                    ::TYPE_STRING
            );

            // GST
            $sheet->setCellValueExplicit(
                'C' . $row,
                (string)$data['tax'],
                PHPExcel_Cell_DataType
                    ::TYPE_STRING
            );

            // INVOICES
            $sheet->setCellValueExplicit(
                'D' . $row,
                (string)$data['invoices'],
                PHPExcel_Cell_DataType
                    ::TYPE_STRING
            );

            // TOTALS
            $total_taxable +=
                (float)$data['sub_total'];

            $total_gst +=
                (float)$data['tax'];

            $total_invoices +=
                (int)$data['invoices'];

            $row++;
        }
    }

    // TOTAL ROW
    $sheet->setCellValue(
        'A' . $row,
        'TOTAL'
    );

    $sheet->setCellValueExplicit(
        'B' . $row,
        (string)$total_taxable,
        PHPExcel_Cell_DataType
            ::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'C' . $row,
        (string)$total_gst,
        PHPExcel_Cell_DataType
            ::TYPE_STRING
    );

    $sheet->setCellValueExplicit(
        'D' . $row,
        (string)$total_invoices,
        PHPExcel_Cell_DataType
            ::TYPE_STRING
    );

    // TOTAL ROW STYLE
    $sheet->getStyle(
        'A' . $row . ':D' . $row
    )->getFont()->setBold(true);

    // AUTO WIDTH
    foreach (range('A', 'D') as $column) {

        $sheet->getColumnDimension(
            $column
        )->setAutoSize(true);
    }

    // FILE NAME
    $filename =
        "statewise_gst_report.xls";

    // DOWNLOAD HEADERS
    header(
        'Content-Type: application/vnd.ms-excel'
    );

    header(
        'Content-Disposition: attachment;filename="' .
        $filename .
        '"'
    );

    header(
        'Cache-Control: max-age=0'
    );

    // WRITER
    $writer =
        PHPExcel_IOFactory
            ::createWriter(
                $excel,
                'Excel5'
            );

    $writer->save('php://output');

    exit;
}
}