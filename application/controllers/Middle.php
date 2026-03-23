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
}