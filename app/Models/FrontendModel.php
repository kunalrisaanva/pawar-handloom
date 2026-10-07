<?php

namespace App\Models;

use CodeIgniter\Model;

class FrontendModel extends Model
{
    public function select_row($table, $where=array(), $order_by = null){
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where($where);
        if ($order_by && isset($order_by['column']) && isset($order_by['direction'])) {
            $builder->orderBy($order_by['column'], $order_by['direction']);
        }
        $result = $builder->get();
    
        //echo $this->db->getLastQuery();die;
        return $result->getRow();
    
       }
       public function select_data($table, $where = [], $group_by = null, $order_by = null, $limit = null, $subSubCatIds = null) {
        $builder = $this->db->table($table);
        $builder->select('*');
        
        // Apply standard where conditions
        if (!empty($where)) {
            $builder->where($where);
        }
    
        // Apply whereIn condition separately
        if (!empty($subSubCatIds)) {
            $builder->whereIn('sub_subCategory', $subSubCatIds);
        }
    
        if ($group_by && isset($group_by['column'])) {
            $builder->groupBy($group_by['column']);
        }
    
        if ($order_by && isset($order_by['column']) && isset($order_by['direction'])) {
            $builder->orderBy($order_by['column'], $order_by['direction']);
        }
    
        if ($limit) {
            if (is_array($limit) && count($limit) == 2) {
                $builder->limit($limit['limit'], $limit['offset']);
            } else {
                $builder->limit($limit);
            }
        }
    
        $result = $builder->get();
        // echo"Get Query check<pre>". $builder->getCompiledSelect();
        // die;
       // echo $this->db->getLastQuery(); die;// Debugging SQL query
        // if ($table == TBL_PRODUCT && !empty($order_by)) {
        //     echo "<pre>";
        //     echo $builder->getCompiledSelect();
        //     die;
        // }
        return $result->getResult();
    }
    public function insert_data($table,$data){
        $builder = $this->db->table($table);   
        $builder->insert($data);
        return $this->db->insertID();
     }
     public function update_data($table,$where,$data){
        $builder = $this->db->table($table);
        $builder->where($where);
        $builder->update($data);
        return true;
     }
     public function delete_data($table,$where,$data){
        $builder = $this->db->table($table);
        $builder->where($where);
        $builder->update($data);
        //echo $this->db->getLastQuery();
        //die;
        return true;
     }
     //Review function
     public function getReviewStats()
        {
            $builder = $this->db->table(TBL_REVIEW);
            $builder->select('rating, COUNT(*) as count');
            $builder->where('status', 1);
            $builder->where('is_deleted', 1);
            $builder->groupBy('rating');
            return $builder->get()->getResultArray();
        }
        // Search Function 
   public function searchProducts($keyword, $limit = 10)
{
    return $this->db->table(TBL_PRODUCT . ' p')
        ->select('
            p.id,
            p.product_name,
            p.offer_price,
            c.category_name,
            sc.name  AS subcategory_name,
            ssc.name AS subsub_category_name
        ')
        ->join(TBL_CATEGORY . ' c', 'c.id = p.category', 'left')
        ->join(TBL_SUBCAT . ' sc', 'sc.id = p.subcategory AND sc.cat_id = c.id', 'left')
        ->join(
            TBL_SUBSUBCAT . ' ssc',
            'ssc.id = p.sub_subCategory AND ssc.sub_cat_id = sc.id',
            'left'
        )
        ->where('p.status', 1)
        ->where('p.is_deleted', 1)
        ->groupStart()
            ->like('p.product_name', $keyword)
            ->orLike('c.category_name', $keyword)
            ->orLike('sc.name', $keyword)
            ->orLike('ssc.name', $keyword)
        ->groupEnd()
        ->limit($limit)
        ->get()
        ->getResultArray();
}




        
        
}
