<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
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
   public function select_data($table, $where=array(), $group_by = null, $order_by = null ,$limit = null){
      $builder = $this->db->table($table);
      $builder->select('*');
      $builder->where($where);
      if ($group_by && isset($group_by['column'])) {
         $builder->groupBy($group_by['column']);
     }
      if ($order_by && isset($order_by['column']) && isset($order_by['direction'])) {
         $builder->orderBy($order_by['column'], $order_by['direction']);
     }
     if ($limit) {
        if (is_array($limit) && count($limit) == 2) {
            // If limit is an array, use offset and limit (e.g., ['offset' => 10, 'limit' => 5])
            $builder->limit($limit['limit'], $limit['offset']);
        } else {
            // If limit is just a number, apply it directly
            $builder->limit($limit);
        }
    }

      $result = $builder->get();
  
      //echo $this->db->getLastQuery();
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
   public function update_category_status($table,$where,$status){
      $builder = $this->db->table($table);
      //$data = $status;
      $builder->where($where);
      $builder->update($status);
      //echo $this->db->getLastQuery();die;
      return true;
    }
    public function count_status($table){
      $builder = $this->db->table($table);
      $builder->select([
          'COUNT(CASE WHEN status = 1 && is_deleted = 1 THEN 1 END) AS status_1_count',
          'COUNT(CASE WHEN status = 0 && is_deleted = 1 THEN 1 END) AS status_0_count',
          'COUNT(CASE WHEN is_deleted = 1 THEN id END) AS total_count'
      ]);    
      $result = $builder->get();   
      //echo $this->db->getLastQuery();
      return $result->getRow();
  }
  //Count Paid and Unpaid customer
  public function count_paidUnpaid($table){
   $builder = $this->db->table($table);
   $builder->select([
       'COUNT(CASE WHEN upcoming_paid = 1 && is_deleted = 1 THEN 1 END) AS upcoming_paid_1_count',
       'COUNT(CASE WHEN upcoming_paid = 0 && is_deleted = 1 THEN 1 END) AS upcoming_paid_0_count',
       'COUNT(CASE WHEN is_deleted = 1 THEN id END) AS total_count'
   ]);    
   $result = $builder->get();   
   //echo $this->db->getLastQuery();
   return $result->getRow();
}
  
  public function select_dataJoin($table1,$table2,$value1,$value2, $where=array(),$TableFields=null){
   $builder = $this->db->table($table1);
   $builder->select("$table1.*");
   // Select fields from $table2
   foreach ($TableFields as $field) {
        $alias = $table2 . "_" . $field;
      $builder->select("$table2.$field AS $alias");
   }
   $builder->join($table2, "$table2.$value2 = $table1.$value1", 'inner');  // Assuming there's a relationship between the tables, adjust the join condition accordingly
   //$builder->where($where);
   foreach ($where as $column => $value) {
      $builder->where("$table1.$column", $value);
  }
   $result = $builder->get();
    //echo $this->db->getLastQuery();
    //die;
   return $result->getResult();

  }

  public function select_dataJoin3tbl($table1, $table2, $value1, $value2, $table3, $value3, $TableFields1 = [], $TableFields2 = [], $where = [])
{
    $builder = $this->db->table($table1);
    $builder->select("$table1.*"); // Select all fields from table1

    // Select specific fields from table2 (Subcategory Table)
    foreach ($TableFields1 as $field) {
        $alias = $table2 . "_" . $field;
        $builder->select("$table2.$field AS $alias");
    }

    // Select specific fields from table3 (Category Table)
    foreach ($TableFields2 as $field) {
        $alias = $table3 . "_" . $field;
        $builder->select("$table3.$field AS $alias");
    }

    // Joining Subcategory Table
    $builder->join($table2, "$table2.$value2 = $table1.$value1", 'inner');

    // Joining Category Table
    $builder->join($table3, "$table3.id = $table2.$value3", 'inner');

    // Applying WHERE conditions
    foreach ($where as $column => $value) {
        $builder->where($column, $value);
    }

    $result = $builder->get();
    //echo $this->db->getLastQuery();
    //die;
    return $result->getResult();
}
  


  public function select_dataJoin3(){
   $builder = $this->db->table('tbl_childcategory');
   $builder->select('tbl_childcategory.*,tbl_subcategory.name as subCatName,tbl_category.category_name as category_name');
   $builder->join('tbl_subcategory', "tbl_subcategory.sub_cat_id = tbl_childcategory.sub_id", 'inner');  // Assuming there's a relationship between the tables, adjust the join condition accordingly
   $builder->join('tbl_category', "tbl_category.id = tbl_childcategory.cat_id", 'inner');  // Assuming there's a relationship between the tables, adjust the join condition accordingly
   //$builder->where($where);
      $builder->where("tbl_childcategory.is_deleted= 1");
   $result = $builder->get();
    //echo $this->db->getLastQuery();
    //die;
   return $result->getResult();

  }
//   Get Shift TIme
public function getShiftTimesByShiftName($shiftName)
{
   $builder = $this->db->table(TBL_SHIFT);
   $builder->select('shift_time_start, shift_time_end');
   $builder->where('shift_name', $shiftName);
   $query = $builder->get();
   
   $shiftTimes = [];
   foreach ($query->getResult() as $row) {
       $shiftTimes[] = $row->shift_time_start . '-' . $row->shift_time_end;
   }
   return $shiftTimes;
}
//Get Today Birthday
public function getTodayBirthday($table, $where)
{
    $today = date('Y-m-d');
    $builder = $this->db->table($table);
    $builder->where($where);
    $builder->where('DATE_FORMAT(dob, "%m-%d") =', date('m-d', strtotime($today)));

    $query = $builder->get();
    return $query->getResult();
}
//Get Upcoming Birthday
   public function getUpcomingBirthday($table, $where)
   {
      $today = date('Y-m-d');
      $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));
      $builder = $this->db->table($table);
      $builder->where($where);
      $builder->where('DATE_FORMAT(dob, "%m-%d") >', date('m-d', strtotime($today)));
      $builder->where('DATE_FORMAT(dob, "%m-%d") <=', date('m-d', strtotime($sevenDaysLater)));
      $query = $builder->get();
      //echo $this->db->getLastQuery(); die;
      return $query->getResult();
   }
//Get Customers Payment List
   public function getCustomerPaymentList($table, $where = array(), $group_by = null, $order_by = null) {
         if ($group_by && isset($group_by['column'])) {
             $subquery = $this->db->table($table)
                                  ->select($group_by['column'] . ', MAX(`id`) as max_id')
                                  ->where($where)
                                  ->groupBy($group_by['column'])
                                  ->getCompiledSelect();
         }
         $builder = $this->db->table($table . ' mp');
         $builder->select('mp.*');
         $builder->where($where);
         if (isset($subquery)) {
             $builder->join("($subquery) as grouped", 'mp.`id` = grouped.max_id');
         }
         if ($order_by && isset($order_by['column']) && isset($order_by['direction'])) {
             $builder->orderBy($order_by['column'], $order_by['direction']);
         }
         $result = $builder->get();
         //echo $this->db->getLastQuery();
     
         return $result->getResult();
     }
// Get Reminder Payment 
/*public function get_reminderPayment($table, $where = array())
{
    $builder = $this->db->table($table);
    $builder->select('*');
    if (!empty($where)) {
        $builder->where($where);
    }
    $builder->where('next_due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 2 DAY)');
    //$builder->where('status', 1);
    //$builder->where('is_deleted', 1);
    $builder->groupBy('user_id');
    $builder->orderBy('id', 'DESC');
    $result = $builder->get();
    //echo $this->db->getLastQuery();die;
    return $result->getResult();
}*/
public function get_reminderPayment($table, $where = array(), $group_by = null, $order_by = null) {
   if ($group_by && isset($group_by['column'])) {
       $subquery = $this->db->table($table)
                            ->select($group_by['column'] . ', MAX(`id`) as max_id')
                            ->where($where)
                            ->groupBy($group_by['column'])
                            ->getCompiledSelect();
   }
   
   $builder = $this->db->table($table . ' mp');
   $builder->select('mp.*');
   
   if (!empty($where)) {
       $builder->where($where);
   }
   
   // Add the date range condition
   $builder->where('next_due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 2 DAY)');
   
   if (isset($subquery)) {
       $builder->join("($subquery) as grouped", 'mp.`id` = grouped.max_id');
   }
   
   if ($order_by && isset($order_by['column']) && isset($order_by['direction'])) {
       $builder->orderBy($order_by['column'], $order_by['direction']);
   } else {
       // Default order by id DESC if no order_by is provided
       $builder->orderBy('id', 'DESC');
   }
   
   $result = $builder->get();
   // echo $this->db->getLastQuery();die;
   
   return $result->getResult();
}
public function getSubCategoryByCategory($category_id)
{
   $builder = $this->db->table(TBL_SUBCAT);
   $builder->select('id, name');
   $builder->where('cat_id', $category_id);
   $query = $builder->get();
    //echo $this->db->getLastQuery(); die;
   $data = [];
   //$categoryName = [];
   foreach ($query->getResult() as $row) {
      $data[] = [
         'id' => $row->id,
         'name' => $row->name
      ];
   }
   //echo"<pre>";print_r($data);die;
   return $data;
}
public function getsubSubCategoryByCategory($category_id,$subcategory_id){
    $builder = $this->db->table(TBL_SUBSUBCAT);
    $builder->select('id, name');
    $builder->where('cat_id', $category_id);
    $builder->where('sub_cat_id', $subcategory_id);
    $query = $builder->get();
    $data = [];
    //$categoryName = [];
    foreach ($query->getResult() as $row) {
       $data[] = [
          'id' => $row->id,
          'name' => $row->name
       ];
    }
    //echo"<pre>";print_r($data);die;
    return $data;
}

//Getting Customer's and resaller orders list
// public function getCustomerOrders()
// {
//     return $this->db->table(TBL_ORDER . ' o')
//         ->select('o.*')
//         ->join(TBL_USER . ' u', 'u.id = o.login_user_id', 'left')
//         ->where('o.is_deleted', '1')
//         ->where('u.role', '2')
//         ->orderBy('o.order_id', 'DESC')
//         ->get()
//         ->getResult();
// }
public function getCustomerOrders()
{
    return $this->db->table(TBL_ORDER . ' o')
        ->select('o.*, u.name, u.email, oi.product_id, oi.qty, oi.price,, oi.color')
        ->join(TBL_USER . ' u', 'u.id = o.login_user_id', 'inner')
        ->join(TBL_ORDERITEMS . ' oi', 'oi.order_id = o.order_id', 'left')
        ->where('o.is_deleted', '1')
        ->where('u.role', '2')
        ->orderBy('o.order_id', 'DESC')
        ->get()
        ->getResult();
}

public function getResallerOrders()
{
    return $this->db->table(TBL_ORDER . ' o')
        ->select('o.*, u.name, u.email, oi.product_id, oi.qty, oi.price,, oi.color')
        ->join(TBL_USER . ' u', 'u.id = o.login_user_id', 'inner')
        ->join(TBL_ORDERITEMS . ' oi', 'oi.order_id = o.order_id', 'left')
        ->where('o.is_deleted', '1')
        ->where('u.role', '1')
        ->orderBy('o.order_id', 'DESC')
        ->get()
        ->getResult();
}

}
