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

    // POST DATA
    $postData = [
        'sub_category_id' => $this->input->post('sub_category_id'),
        'product_name'    => $this->input->post('product_name'),
        'price'           => $this->input->post('price'),
        'description'     => $this->input->post('description'),
        'stock'           => $this->input->post('stock'),
        'status'          => $this->input->post('status')
    ];

    // ✅ ATTRIBUTES (IMPORTANT)
    $attributes = $this->input->post('attributes'); // should be array
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

    // ✅ FILE UPLOAD SUPPORT
    $files = $_FILES['media'];
    if (!empty($files['name'][0])) {
        for ($i = 0; $i < count($files['name']); $i++) {
            $postData['media['.$i.']'] = new CURLFile(
                $files['tmp_name'][$i],
                $files['type'][$i],
                $files['name'][$i]
            );
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

    // ✅ SUCCESS
    echo json_encode([
        'status' => true,
        'message' => 'Product added successfully'
    ]);
}

}