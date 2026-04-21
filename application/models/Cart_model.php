<?php

Defined ('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
/*
   public function added_to_cart($user_id, $product_id, $quantity) {
                $exists = $this->db->get_where('cart_tbl', [
                'user_id' => $user_id,
                'product_id' => $product_id,
                'cart_status' => 1
            ])->row_array();
                

        if ($exists) {
            $new_qty = $exists['quantity'] + $quantity;
            $this->db->update('cart_tbl', ['quantity' => $new_qty], ['id' => $exists['id']]);
            return 'updated';
        }

        $this->db->insert('cart_tbl', [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'cart_status' => 1
        ]);
        return 'added';
    }*/
/*

        public function added_to_cart($user_id, $product_id, $quantity) {

    $quantity = (int)$quantity;
    $quantity = max(1, $quantity);

    $exists = $this->db->get_where('cart_tbl', [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'cart_status' => 1
    ])->row_array();

    if ($exists) {
        $new_qty = (int)$exists['quantity'] + $quantity;

        $this->db->update('cart_tbl', 
            ['quantity' => $new_qty], 
            ['id' => $exists['id']]
        );

        return 'updated';
    }

    $this->db->insert('cart_tbl', [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => $quantity,
        'cart_status' => 1
    ]);

    return 'added';
}*/
/*
public function added_to_cart($user_id, $product_id, $quantity)
{
    $quantity = (int)$quantity;
    $quantity = max(1, $quantity);

    $exists = $this->db->get_where('cart_tbl', [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'cart_status' => 1
    ])->row_array();

    if ($exists) {

        // ✅ FIX: overwrite instead of add
        $this->db->update(
            'cart_tbl',
            ['quantity' => $quantity],
            ['id' => $exists['id']]
        );

        return 'updated';
    }

    $this->db->insert('cart_tbl', [
        'user_id' => $user_id,
        'product_id' => $product_id,
        'quantity' => $quantity,
        'cart_status' => 1
    ]);

    return 'added';
}*/

public function added_to_cart($user_id, $product_id, $quantity)
{
    // ✅ CHECK PRODUCT EXISTS
    $product = $this->db->get_where('product_tbl', ['id' => $product_id])->row_array();

    if (!$product) {
        return false; // product not found
    }

    // ✅ CHECK IF ALREADY IN CART
    $existing = $this->db->get_where('cart_tbl', [
        'user_id' => $user_id,
        'product_id' => $product_id
    ])->row_array();

    if ($existing) {
        // ✅ UPDATE QUANTITY
        $new_qty = $existing['quantity'] + $quantity;

        $this->db->where('id', $existing['id']);
        $this->db->update('cart_tbl', [
            'quantity' => $new_qty,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return 'updated';
    } else {
        // ✅ INSERT NEW
        $this->db->insert('cart_tbl', [
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'cart_status' => 1,
            'delete_status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return 'added';
    }
}


    public function remove_from_cart($user_id, $product_id) {
        $this->db->delete('cart_tbl', [
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
    }
/*
    public function get_cart_by_user_id($user_id) {
        $this->db->select('
            c.id,
            c.product_id,
            c.quantity as qty,
            c.cart_status,
            p.product_name,
            p.price,
            c.category_id,
            c.category_name,
            MIN(pm.media_path) as image_url
        ');

        $this->db->from('cart_tbl c');
        $this->db->join('product_tbl p', 'c.product_id = p.id', 'left');
        $this->db->join('product_media_tbl pm', 'pm.product_id = p.id AND pm.media_type = "image" AND pm.delete_status = 0', 'left');
        $this->db->where('c.user_id', $user_id);
        $this->db->group_by('c.id'); 

        return $this->db->get()->result_array();
    }
*/
/*
public function get_cart_by_user_id($user_id) {

    $this->db->select('
        c.id as cart_id,
        c.product_id,
        c.quantity as qty,
        c.cart_status,

        p.product_name,
        p.price,
        p.strike_price,
        p.description,
        p.stock,
        p.badge,
        p.rating,

        sc.id as sub_category_id,
        sc.sub_category_name,

        cat.id as category_id,
        cat.category_name,

        MIN(pm.media_path) as image_url
    ');

    $this->db->from('cart_tbl c');

    // product
    $this->db->join('product_tbl p', 'c.product_id = p.id', 'left');

    // subcategory
    $this->db->join('sub_category_tbl sc', 'sc.id = p.sub_category_id', 'left');

    // category
    $this->db->join('category_tbl cat', 'cat.id = sc.category_id', 'left');

    // image
    $this->db->join(
        'product_media_tbl pm',
        'pm.product_id = p.id AND pm.media_type = "photo" AND pm.delete_status = 0',
        'left'
    );

    $this->db->where('c.user_id', $user_id);
    $this->db->where('c.cart_status', 1);

    $this->db->group_by('c.id');

    return $this->db->get()->result_array();
}
 */

public function get_cart_by_user_id($user_id) {

    $this->db->select('
        c.id as cart_id,
        c.product_id,
        c.quantity,
        c.cart_status,

        p.product_name,
        p.price,
        p.strike_price,
        p.description,
        p.stock,
        p.badge,
        p.rating,

        sc.id as sub_category_id,
        sc.sub_category_name,

        cat.id as category_id,
        cat.category_name,

        MIN(pm.media_path) as image_url
    ');

    $this->db->from('cart_tbl c');

    $this->db->join('product_tbl p', 'c.product_id = p.id', 'left');
    $this->db->join('sub_category_tbl sc', 'sc.id = p.sub_category_id', 'left');
    $this->db->join('category_tbl cat', 'cat.id = sc.category_id', 'left');

    $this->db->join(
        'product_media_tbl pm',
        'pm.product_id = p.id AND pm.media_type = "photo" AND pm.delete_status = 0',
        'left'
    );

    $this->db->where('c.user_id', $user_id);
    $this->db->where('c.cart_status', 1);
    $this->db->where('c.delete_status', 0); // ✅ FIX

    $this->db->group_by('c.id');

    return $this->db->get()->result_array();
}

//cart count

public function get_cart_count($user_id) {
    $this->db->where('user_id', $user_id);
    $this->db->where('cart_status', 1);
    return $this->db->count_all_results('cart_tbl');    
}

//clear cart

/*public function clear_cart($user_id)
{
    $this->db->where('user_id', $user_id);
    return $this->db->update('cart_tbl');
}*/

public function clear_cart($user_id)
{
    $this->db->where('user_id', $user_id);
    $this->db->where('cart_status', 1); // optional filter
    return $this->db->update('cart_tbl', [
        'cart_status' => 0,
        'delete_status' => 1
    ]);
}
/*
public function get_cart_total($user_id)
{
    $this->db->select('SUM(c.quantity * p.price) as total');
    $this->db->from('cart_tbl c');
    $this->db->join('product_tbl p', 'c.product_id = p.id');
    $this->db->where('c.user_id', $user_id);

    $result = $this->db->get()->row_array();

    return (!empty($result['total'])) ? $result['total'] : 0;
}*/

public function get_cart_total($user_id)
{
    $this->db->select('SUM(c.quantity * p.price) as total');
    $this->db->from('cart_tbl c');
    $this->db->join('product_tbl p', 'p.id = c.product_id', 'left');
    $this->db->where('c.user_id', $user_id);
    $this->db->where('c.cart_status', 1); // optional but recommended

    $result = $this->db->get()->row();

    return $result->total ?? 0;
}
}
