<?php

defined ('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {

    public function insert_product($data)
    {
        return $this->db->insert('product_tbl', $data);
    }

//product by id

    public function get_product_by_id($id)
{
    $this->db->where('id',$id)
             ->where('delete_status',0);       
    return $this->db->get('product_tbl')->row_array();

}


//product media


  public function add_media($data)
    {
        // ✅ IMPORTANT: force delete_status = 0
        if (!isset($data['delete_status'])) {
            $data['delete_status'] = 0;
        }

        return $this->db->insert('product_media_tbl', $data);
    }

//update

public function update_product($id,$data)
{
    $this->db->where('id',$id);
    return $this->db->update('product_tbl',$data);
}

//delete


    public function soft_delete_product($id)
    {
        $this->db->where('id',$id)
                ->update('product_tbl',['delete_status' => 1]);
        
        $this->db->where('product_id',$id)
                ->update('product_media_tbl',['delete_status' => 1]);
        
        $this->db->where('product_id',$id)
                    ->update('product_attribute_tbl',['delete_status'=>1]);

          

        return true;
    }

//list


public function get_products()
{
    $this->db->where('delete_status',0);
    return $this->db->get('product_tbl')->result_array();
}





//list + media

/*public function get_produuct_list(){

$this->db->select('
            p.id, p.product_name,p.price, p.description,p.stock,
            p.status, 
            m.media_type, m.media_path
        ');
        $this->db->from('product_tbl p');
        $this->db->where('w.delete_status', 0);

        $this->db->join(
            'product_media m',
            'm.work_id = w.id AND m.delete_status = 0',
            'LEFT'
        );

        $this->db->order_by('w.id', 'DESC');
        $query = $this->db->get()->result_array();

        $result = [];

        foreach ($query as $row) {
            $id = $row['id'];

            if (!isset($result[$id])) {
                $result[$id] = [
                    'id' => $id,
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'location' => $row['location'],
                    'status' => $row['status'],
                    'start_date' => $row['start_date'],
                    'end_date' => $row['end_date'],
                    'created_at' => $row['created_at'],
                    'photos' => [],
                    'videos' => []
                ];
            }

            if ($row['media_type'] === 'photo') {
                $result[$id]['photos'][] = base_url($row['media_path']);
            }

            if ($row['media_type'] === 'video') {
                $result[$id]['videos'][] = base_url($row['media_path']);
            }
        }

        return array_values($result);
 


}
    
*/

    public function get_product_list()
    {
        
        
                        $this->db->select('
                p.id,
                p.product_name,
                p.price,
                p.description,
                p.stock,
                p.status,
                sc.id as sub_category_id,
                sc.sub_category_name,
                c.id as category_id,
                c.category_name
            ');
                
        $this->db->from('product_tbl p');
        $this->db->join('sub_category_tbl sc', 'sc.id = p.sub_category_id', 'left');
        $this->db->join('category_tbl c', 'c.id = sc.category_id', 'left');

        $this->db->where('p.delete_status', 0);

        $products = $this->db->get()->result_array();

        // Attach media
        foreach ($products as &$product) {
    $product['media'] = $this->get_product_media($product['id']);
    $product['attributes'] = $this->get_product_attributes($product['id']);
}
        

        return $products;
    }


    public function get_product_attributes($product_id)
{
    $this->db->select('
        pa.attribute_id,
        a.attribute_name,
        pa.value
    ');
    $this->db->from('product_attribute_tbl pa');
    $this->db->join('attributes_tbl a', 'a.id = pa.attribute_id', 'left');
    $this->db->where('pa.product_id', $product_id);

    return $this->db->get()->result_array();
}

    public function get_product_media($product_id)
    {
        $this->db->select('id, media_type, media_path');
        $this->db->from('product_media_tbl');
        $this->db->where('product_id', $product_id);
        $this->db->where('delete_status', 0);

        return $this->db->get()->result_array();
    }

    public function insert_product_attribute($data)
{
    return $this->db->insert('product_attribute_tbl', $data);
}

public function upsert_product_attribute($data)
{
    $this->db->where('product_id', $data['product_id']);
    $this->db->where('attribute_id', $data['attribute_id']);

    $query = $this->db->get('product_attribute_tbl');

    if ($query->num_rows() > 0) {
        // UPDATE
        $this->db->where('product_id', $data['product_id']);
        $this->db->where('attribute_id', $data['attribute_id']);
        $this->db->update('product_attribute_tbl', [
            "value" => $data['value']
        ]);
    } else {
        // INSERT
        $this->db->insert('product_attribute_tbl', $data);
    }
}
}