<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Wishlist_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*public function get_wishlist_by_user_id($user_id) {
        $this->db->select('w.*, p.name as product_name, p.price as price, p.stock as stock, p.description as description, p.status as status');
        $this->db->from('wishlist_tbl w');
        $this->db->join('product_tbl p', 'w.product_id = p.id', 'left');
        $this->db->where('w.user_id', $user_id);
        $this->db->where('w.status', 1); 
        return $this->db->get()->result_array();
    }*/
    
    public function get_wishlist_by_user_id($user_id) {
    $this->db->select('
        w.*, 
        p.product_name, 
        p.price, 
        p.stock, 
        p.description, 
        p.status,
        pm.media_path as product_image
    ');
    
    $this->db->from('wishlist_tbl w');
    $this->db->join('product_tbl p', 'w.product_id = p.id', 'left');
    $this->db->join('product_media_tbl pm', 'pm.product_id = p.id AND pm.media_type AND pm.delete_status = 0', 'left');

    $this->db->where('w.user_id', $user_id);
    $this->db->where('w.status', 1);
    $this->db->where('w.delete_status', 0);
    $this->db->where('p.delete_status', 0);
    $this->db->where('pm.delete_status', 0);

    $this->db->group_by('w.id'); 

    return $this->db->get()->result_array();
}
    public function add_to_wishlist($user_id, $product_id)
    {
        $exists = $this->db->get_where('wishlist_tbl', [
        'user_id' => $user_id,
        'product_id' => $product_id
        ])->row();

    if ($exists) {

        // If already exists but removed earlier → make active again
        if ($exists->status == 0) {
            $this->db->where('id', $exists->id);
            $this->db->update('wishlist_tbl', [
                'status' => 1
            ]);
            return 'updated'; // 🔥 important
        }

        // Already active
        return false;
    }

    // Insert new
    $this->db->insert('wishlist_tbl', [
        'user_id' => $user_id,
        'product_id' => $product_id
        // status default = 1
    ]);

    return 'added';
}

public function remove_from_wishlist($user_id, $product_id)
{
    $this->db->where([
        'user_id' => $user_id,
        'product_id' => $product_id
    ]);

    $this->db->update('wishlist_tbl', [
        'status' => 0
    ]);

    return true;
}
}