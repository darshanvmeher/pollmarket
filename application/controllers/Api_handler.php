<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Mpdf\Mpdf;

class Api_handler extends CI_Controller {

    public function __construct() {
        parent::__construct();

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
        "description" => $this->input->post('description'),
        "stock" => $this->input->post('stock'),
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
        "discount" => $this->input->post('discount'),
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
        "discount" => $this->input->post('discount'),
        "validity" => $this->input->post('validity'),
        "status" => $this->input->post('status'),
        "description" => $this->input->post('description')
    ];
    
    $update = $this->Promotion_model->update_promotion($id, $data);
    
    echo json_encode([
        "status" => $update,
        "message" => $update ? "Coupon updated" : "Update failed"
    ]);

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

    $user_id = $this->input->post('user_id');
    $product_id = $this->input->post('product_id');

    if (empty($user_id) || empty($product_id)) {
        echo json_encode([
            "status" => false,
            "message" => "User ID and Product ID are required"
        ]);
        return;
    }

    $result = $this->Wishlist_model->add_to_wishlist($user_id, $product_id);

    if ($result == 'added') {
        echo json_encode([
            "status" => true,
            "message" => "Added to wishlist successfully"
        ]);
    } elseif ($result == 'updated') {
        echo json_encode([
            "status" => true,
            "message" => "Added to wishlist again"
        ]);
    } else {
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

    $user_id = $this->input->post('user_id');
    $product_id = $this->input->post('product_id');

    if (empty($user_id) || empty($product_id)) {
        echo json_encode([
            "status" => false,
            "message" => "User ID and Product ID are required"
        ]);
        return;
    }

    $delete = $this->Wishlist_model->remove_from_wishlist($user_id, $product_id);

    echo json_encode([
        "status" => $delete ? true : false,
        "message" => $delete ? "Removed successfully" : "Failed"
    ]);
}



//wishlist list
public function wishlist()
{
    $decoded = $this->verify_token(); 
    $user_id = $decoded->customer_id;  
    
    $user_id = $this->input->post('user_id');

    if (empty($user_id)) {
        echo json_encode([
            "status" => false,
            "message" => "User ID is required"
        ]);
        return;
    }

    $wishlist = $this->Wishlist_model->get_wishlist_by_user_id($user_id);

    echo json_encode([
        "status" => true,
        "data" => $wishlist
    ]);
}

}