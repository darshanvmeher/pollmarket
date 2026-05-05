<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Middle extends CI_Controller {

    public function __construct() {

        parent :: __construct();

              


    
    }


    public function login_view()
{
    $data['error'] = $this->session->flashdata('error');
    $this->load->view('admin/pages/login', $data);
}

    public function log_in(){

    $email  = trim($this->input->post('email'));
    $password = trim($this->input->post('password'));    

    $url=base_url('index.php/api_handler/admin_login');

    
    $postData = [
        'email'   => $email,
        'password' => $password
    ];

     $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
          $this->session->set_flashdata('error', curl_error($ch));
    redirect('middle/login_view');
     return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    // ✅ Check API response format
  if (!$result || !isset($result['status'])) {
    $this->session->set_flashdata('error', "Invalid API response");
    redirect('middle/login_view');
    return;
}

    // ❌ Login failed
    if ($result['status'] == false) {
         $this->session->set_flashdata('error', $result['message']);
        redirect('middle/login_view');
        return;
    }

    // ✅ LOGIN SUCCESS → SET SESSION
    $sessionData = [
        'user_id'   => $result['data']['id'],
        'firstname' => $result['data']['firstname'],
        'lastname' => $result['data']['lastname'],
        'email'    => $result['data']['email'],
        'role'      => $result['data']['role'],
        'token' => $result['token'] ,
        'is_logged' => true
    ];

    $this->session->set_userdata($sessionData);


       redirect('admin');

    }

  public function dashboard_view()
{
    
    if (!$this->session->userdata('is_logged')) {
        redirect('middle/login_view');
    }

    $data['kpis'] = []; // avoid error

    $this->load->view('admin/pages/dashboard', $data);
}

  /*public function categories_view()
{
    
    if (!$this->session->userdata('is_logged')) {
        redirect('middle/login_view');
    }  

    $this->load->view('admin/pages/categories');
}*/
/*
public function categories_view()
{
    if (!$this->session->userdata('is_logged')) {
        redirect('middle/login_view');
    }

    $this->load->model('Category_model');

    $data['categories'] = $this->Category_model->get_categories();

    $this->load->view('admin/pages/categories', $data);
}*/

public function categories_view()
{
    if (!$this->session->userdata('is_logged')) {
        redirect('middle/login_view');
    }

    $this->load->model('Category_model');

    $data['categories'] = $this->Category_model->get_categories();

    // ✅ ADD THIS LINE (VERY IMPORTANT)
    $data['status_options'] = ['Active', 'Draft', 'Review'];

    $this->load->view('admin/pages/categories', $data);
}
//add
/*
public function adding_categories()
{
    if (!$this->session->userdata('is_logged')) {
        redirect('middle/login_view');
    }

    $postData = [
        'category_name' => $this->input->post('category_name'),
        'description'   => $this->input->post('description'),
        'status'        => $this->input->post('status')
    ];

    $url = base_url('index.php/api_handler/add_category');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // ✅ If using JWT token (IMPORTANT)
   /* $token = $this->session->userdata('token'); // store token at login
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
    ]);*/
/*
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $this->session->set_flashdata('error', curl_error($ch));
       // redirect('middle/categories_view');
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        $this->session->set_flashdata('error', 'Invalid API response');
      //  redirect('middle/categories_view');
        return;
    }

    if ($result['status'] == false) {
        $this->session->set_flashdata('error', $result['message']);
      //  redirect('middle/categories_view');
        return;
    }

    // ✅ SUCCESS
    $this->session->set_flashdata('success', 'Category added successfully');
  //  redirect('middle/categories_view');
}*/

public function adding_categories()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'category_name' => $this->input->post('category_name'),
        'description'   => $this->input->post('description'),
        'status'        => $this->input->post('status')
    ];

    $url = base_url('index.php/api_handler/add_category');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    // ✅ SUCCESS RESPONSE (IMPORTANT)
    echo json_encode([
        'status' => true,
        'message' => 'Category added successfully'
    ]);
}

public function updating_categories()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'id'            =>$this->input->post('id'),
        'category_name' => $this->input->post('category_name'),
        'description'   => $this->input->post('description'),
        'status'        => $this->input->post('status')
    ];

    $url = base_url('index.php/api_handler/update_category');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    // ✅ SUCCESS RESPONSE (IMPORTANT)
    echo json_encode([
        'status' => true,
        'message' => 'Category updated successfully'
    ]);
}

public function deleting_categories()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'id'        => $this->input->post('id')
    ];

    $url = base_url('index.php/api_handler/delete_category');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    // ✅ SUCCESS RESPONSE (IMPORTANT)
    echo json_encode([
        'status' => true,
        'message' => 'Category deleted successfully'
    ]);
}

//subcategories

public function subcategories_view()
{
    if (!$this->session->userdata('is_logged')) {
     redirect('middle/login_view');
    }

    $this->load->model('Sub_category_model');
    $this->load->model('Category_model');


    $data['subcategories'] = $this->Sub_category_model->get_all_subcategories();
    $data['categories'] = $this->Category_model->get_categories();


    // ✅ ADD THIS LINE (VERY IMPORTANT)
    $data['status_options'] = ['Active', 'Draft', 'Review'];

    $this->load->view('admin/pages/subcategories', $data);
}

public function adding_subcategories()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'category_id'=> $this->input->post('category_id'),
        'sub_category_name' => $this->input->post('sub_category_name'),
        'description'   => $this->input->post('description'),
        'status'        => $this->input->post('status')
    ];

    $url = base_url('index.php/api_handler/add_subcategory');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    // ✅ SUCCESS RESPONSE (IMPORTANT)
    echo json_encode([
        'status' => true,
        'message' => 'Subcategory added successfully'
    ]);
}

public function updating_subcategories()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'id'            =>$this->input->post('id'),
        'category_id'   =>$this->input->post('category_id'),
        'sub_category_name' => $this->input->post('sub_category_name'),
        'description'   => $this->input->post('description'),
        'status'        => $this->input->post('status')
    ];

    $url = base_url('index.php/api_handler/update_sub_category');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    // ✅ SUCCESS RESPONSE (IMPORTANT)
    echo json_encode([
        'status' => true,
        'message' => 'Subcategory updated successfully'
    ]);
}

public function deleting_subcategories()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'id'        => $this->input->post('id')
    ];

    $url = base_url('index.php/api_handler/delete_sub_category');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    // ✅ SUCCESS RESPONSE (IMPORTANT)
    echo json_encode([
        'status' => true,
        'message' => 'Subcategory deleted successfully'
    ]);
}

public function product_view()
{
     if (!$this->session->userdata('is_logged')) {
     redirect('middle/login_view');
    }

    $this->load->model('Products_model');
    $this->load->model('Sub_category_model');
    $this->load->model('Category_model');


    $data['products'] = $this->Products_model->get_product_list();
    $data['subcategories'] = $this->Sub_category_model->get_all_subcategories();
    $data['categories'] = $this->Category_model->get_categories();
    $data['attributes'] = $this->Attribute_model->get_attributes();




    $this->load->view('admin/pages/products', $data);
}

//add products
public function adding_product()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $url = base_url('index.php/api_handler/add_product');

    // ---------- POST DATA ----------
    $postData = [
        'sub_category_id' => $this->input->post('sub_category_id'),
        'product_name'    => $this->input->post('product_name'),
        'price'           => $this->input->post('price'),
        'strike_price'    => $this->input->post('strike_price'),
        'description'     => $this->input->post('description'),
        'stock'           => $this->input->post('stock'),
        'badge'           => $this->input->post('badge'),
        'rating'          => $this->input->post('rating'),
        'status'          => $this->input->post('status')
    ];

    // ---------- ATTRIBUTES ----------
    $attributes = $this->input->post('attributes');
    if (!empty($attributes)) {
        foreach ($attributes as $key => $attr) {
            $postData["attributes[$key][attribute_id]"] = $attr['attribute_id'];
            $postData["attributes[$key][value]"] = $attr['value'];
        }
    }

    // ---------- CURL INIT ----------
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);

    // ---------- MEDIA FILE ----------
    
  // COMBINE ALL FILES INTO media[]
$mediaIndex = 0;

// PHOTOS
if (!empty($_FILES['photo']['name'][0])) {
    foreach ($_FILES['photo']['name'] as $i => $name) {
        $postData["media[$mediaIndex]"] = new CURLFile(
            $_FILES['photo']['tmp_name'][$i],
            $_FILES['photo']['type'][$i],
            $_FILES['photo']['name'][$i]
        );
        $mediaIndex++;
    }
}

// VIDEOS
if (!empty($_FILES['video']['name'][0])) {
    foreach ($_FILES['video']['name'] as $i => $name) {
        $postData["media[$mediaIndex]"] = new CURLFile(
            $_FILES['video']['tmp_name'][$i],
            $_FILES['video']['type'][$i],
            $_FILES['video']['name'][$i]
        );
        $mediaIndex++;
    }
}


    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // ---------- TOKEN ----------
    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
    ]);

    // ---------- EXEC ----------
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    if (!$response) {
        echo json_encode([
            'status' => false,
            'message' => 'Empty API response'
        ]);
        return;
    }

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    echo json_encode([
        'status' => $result['status'],
        'message' => $result['message']
    ]);
}
//updating

public function updating_product()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $url = base_url('index.php/api_handler/update_product');

    // POST DATA
    $postData = [
        'id'              => $this->input->post('id'),
        'sub_category_id' => $this->input->post('sub_category_id'),
        'product_name'    => $this->input->post('product_name'),
        'price'           => $this->input->post('price'),
        'strike_price'    => $this->input->post('strike_price'),
        'description'     => $this->input->post('description'),
        'stock'           => $this->input->post('stock'),
        'badge'           => $this->input->post('badge'),
        'rating'          => $this->input->post('rating'),
        'status' => $this->input->post('status'),
    ];

    // ✅ ATTRIBUTES
    $attributes = $this->input->post('attributes');
    if (!empty($attributes)) {
        foreach ($attributes as $key => $attr) {
            $postData["attributes[$key][attribute_id]"] = $attr['attribute_id'];
            $postData["attributes[$key][value]"] = $attr['value'];
        }
    }

    // INIT CURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);

    // ✅ FILE UPLOAD
       // ---------- MEDIA FILE ----------
    
    /* ================= PHOTOS ================= */
    // COMBINE ALL FILES INTO media[]
$mediaIndex = 0;

// PHOTOS
if (!empty($_FILES['photo']['name'][0])) {
    foreach ($_FILES['photo']['name'] as $i => $name) {
        $postData["media[$mediaIndex]"] = new CURLFile(
            $_FILES['photo']['tmp_name'][$i],
            $_FILES['photo']['type'][$i],
            $_FILES['photo']['name'][$i]
        );
        $mediaIndex++;
    }
}

// VIDEOS
if (!empty($_FILES['video']['name'][0])) {
    foreach ($_FILES['video']['name'] as $i => $name) {
        $postData["media[$mediaIndex]"] = new CURLFile(
            $_FILES['video']['tmp_name'][$i],
            $_FILES['video']['type'][$i],
            $_FILES['video']['name'][$i]
        );
        $mediaIndex++;
    }
}

    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // TOKEN
    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    echo json_encode([
        'status' => true,
        'message' => 'Product updated successfully'
    ]);
}

//deleting

public function deleting_product()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $url = base_url('index.php/api_handler/delete_product');

    // POST DATA
    $postData = [
        'id' => $this->input->post('id')
    ];

    // INIT CURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // TOKEN
    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    echo json_encode([
        'status' => true,
        'message' => 'Product deleted successfully'
    ]);
}

//add promotions

public function promotions_view()
{
     if (!$this->session->userdata('is_logged')) {
     redirect('middle/login_view');
    }

    $this->load->model('Promotions_model');

    $data['promotions'] = $this->Promotions_model->get_promotions();

    $this->load->view('admin/pages/promotions', $data); 


}
//add promotion 

public function adding_promotion()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'coupon_code' => $this->input->post('coupon_code'),
        'coupon_type' => $this->input->post('coupon_type'),
        'discount_type' => $this->input->post('discount_type'),
        'discount_value' => $this->input->post('discount_value'),
        'validity' => $this->input->post('validity'),
        'status' => $this->input->post('status'),
        'description' => $this->input->post('description')
    ];

    $url = base_url('index.php/api_handler/add_promotion');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    // ✅ SUCCESS RESPONSE (IMPORTANT)
    echo json_encode([
        'status' => true,
        'message' => 'Coupon added successfully'
    ]);

}

//update promotion

public function updating_promotion()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    // Similar to adding_promotion but with 'id' and different API endpoint
    // Implement the logic here following the same pattern as adding_promotion

    $postData = [
        'id' => $this->input->post('id'),
        'coupon_code' => $this->input->post('coupon_code'),
        'coupon_type' => $this->input->post('coupon_type'),
        'discount_type' => $this->input->post('discount_type'),
        'discount_value' => $this->input->post('discount_value'),
        'validity' => $this->input->post('validity'),
        'status' => $this->input->post('status'),
        'description' => $this->input->post('description')
    ];

    $url = base_url('index.php/api_handler/update_promotion');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $token = $this->session->userdata('token');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }
    curl_close($ch);
    $result = json_decode($response, true);
    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }
    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }
    echo json_encode([
        'status' => true,
        'message' => 'Coupon updated successfully'
    ]);

}

//delete promotion

public function deleting_promotion()
{
    if (!$this->session->userdata('is_logged')) {
        echo json_encode([
            'status' => false,
            'message' => 'Session expired'
        ]);
        return;
    }

    $postData = [
        'id' => $this->input->post('id')
    ];

    $url = base_url('index.php/api_handler/delete_promotion');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token = $this->session->userdata('token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token
]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo json_encode([
            'status' => false,
            'message' => curl_error($ch)
        ]);
        return;
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!$result || !isset($result['status'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid API response'
        ]);
        return;
    }

    if ($result['status'] == false) {
        echo json_encode([
            'status' => false,
            'message' => $result['message']
        ]);
        return;
    }

    echo json_encode([
        'status' => true,
        'message' => 'Coupon deleted successfully'
    ]);
}   

}