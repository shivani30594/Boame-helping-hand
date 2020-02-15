<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PurchasedPointHistory_m extends My_Model{

    protected $_table_name     = 'crm_purchased_point_history';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
    
    function all($limit,$start,$col,$dir)
    {   
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_purchased_point_history WHERE user_id = $user_id ORDER BY $col $dir LIMIT $limit OFFSET $start";
        $query =  $this->db->query($sql);
        if ($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }
    
    function search($limit,$start,$search,$col,$dir)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_purchased_point_history WHERE  user_id = $user_id AND (transaction_id LIKE '%$search%' OR purchased_points LIKE '%$search%' OR purchased_date LIKE '%$search%' OR sender_name LIKE '%$search%' OR is_approved LIKE '%$search%' OR sender_number LIKE '%sender_number%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
        $query =  $this->db->query($sql);
        if ($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function search_count($search)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_purchased_point_history WHERE user_id = $user_id AND (transaction_id LIKE '%$search%' OR purchased_points LIKE '%$search%' OR purchased_date LIKE '%$search%' OR sender_name LIKE '%$search%' OR is_approved LIKE '%$search%' OR sender_number LIKE '%sender_number%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    function all_admin($limit,$start,$col,$dir)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id, usr.first_name, usr.last_name, pph.purchased_points, pph.purchased_date, ref.refferal_code,pph.is_approved, pph.transaction_id from crm_purchased_point_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE pph.is_approved = 'complete' OR pph.is_approved = 'in-progress' OR pph.is_approved = 'pending' ORDER BY $col $dir LIMIT $limit OFFSET $start";
        $query =  $this->db->query($sql);
        if ($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }
    
    function search_admin($limit,$start,$search,$col,$dir)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id,usr.first_name, usr.last_name, pph.purchased_points, pph.purchased_date, ref.refferal_code,pph.is_approved, pph.transaction_id from crm_purchased_point_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE (pph.is_approved = 'complete' OR pph.is_approved = 'in-progress' OR pph.is_approved = 'pending' ) AND (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.purchased_points LIKE '%$search%' OR ref.refferal_code LIKE '%$search%' OR pph.transaction_id LIKE '%$search%' OR pph.is_approved LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
        $query =  $this->db->query($sql);
        if ($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function search_count_admin($search)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id,usr.first_name, usr.last_name, pph.purchased_points, pph.purchased_date, ref.refferal_code,pph.is_approved, pph.transaction_id from crm_purchased_point_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE (pph.is_approved = 'complete' OR pph.is_approved = 'in-progress' OR pph.is_approved = 'pending') AND (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.purchased_points LIKE '%$search%' OR ref.refferal_code LIKE '%$search%' OR pph.transaction_id LIKE '%$search%' OR pph.is_approved LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 


    function all_cancel_user($limit,$start,$col,$dir,$parameter)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id, usr.first_name, usr.last_name, pph.purchased_points, pph.purchased_date, ref.refferal_code,pph.is_approved, pph.transaction_id from crm_purchased_point_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE pph.is_approved = '".$parameter."' ORDER BY $col $dir LIMIT $limit OFFSET $start";
        $query =  $this->db->query($sql);
        if ($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }
    
    function search_cancel_user($limit,$start,$search,$col,$dir,$parameter)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id,usr.first_name, usr.last_name, pph.purchased_points, pph.purchased_date, ref.refferal_code,pph.is_approved, pph.transaction_id from crm_purchased_point_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.purchased_points LIKE '%$search%' OR ref.refferal_code LIKE '%$search%' OR pph.transaction_id LIKE '%$search%' OR pph.is_approved LIKE '%$search%') WHERE pph.is_approved = '".$parameter."' ORDER BY $col $dir LIMIT $limit OFFSET $start";
        $query =  $this->db->query($sql);
        if ($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function search_count_cancel_user($search, $parameter)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id,usr.first_name, usr.last_name, pph.purchased_points, pph.purchased_date, ref.refferal_code,pph.is_approved, pph.transaction_id from crm_purchased_point_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.purchased_points LIKE '%$search%' OR ref.refferal_code LIKE '%$search%' OR pph.transaction_id LIKE '%$search%' OR pph.is_approved LIKE '%$search%') WHERE pph.is_approved = '".$parameter."'";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

}

