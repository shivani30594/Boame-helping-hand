<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserSubscription_m extends My_Model
{
    protected $_table_name     = 'crm_user_subscription_history';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;

    function all($limit,$start,$col,$dir)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_user_subscription_history sh LEFT JOIN crm_subscription s ON s.id = sh.subscription_id WHERE sh.user_id =".$this->session->userdata('user_id')." ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_user_subscription_history sh LEFT JOIN crm_subscription s ON s.id = sh.subscription_id WHERE sh.user_id =".$this->session->userdata('user_id')." AND (s.plan_name LIKE '%$search%' OR s.plan_price LIKE '%$search%' OR s.plan_description LIKE '%$search%' OR sh.start_date LIKE '%$search%' OR sh.end_date LIKE '%$search%' OR sh.status LIKE '%$search%' OR sh.payment_mode LIKE '%$search%' OR sh.address LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_user_subscription_history sh LEFT JOIN crm_subscription s ON s.id = sh.subscription_id WHERE sh.user_id =".$this->session->userdata('user_id')." AND (s.plan_name LIKE '%$search%' OR s.plan_price LIKE '%$search%' OR s.plan_description LIKE '%$search%' OR sh.start_date LIKE '%$search%' OR sh.end_date LIKE '%$search%' OR sh.status LIKE '%$search%' OR sh.payment_mode LIKE '%$search%' OR sh.address LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    function all_admin($limit,$start,$col,$dir)
    {   
        $sql = "SELECT sh.*, CONCAT(up.first_name,' ',up.last_name) as name, s.* from crm_user_subscription_history sh LEFT JOIN crm_subscription s ON s.id = sh.subscription_id LEFT JOIN crm_users_primary up on up.id = sh.user_id ORDER BY $col $dir LIMIT $limit OFFSET $start";
        $query =  $this->db->query($sql);
        // echo $this->db->last_query();
        // die;
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
        $sql = "SELECT sh.*, CONCAT(up.first_name,' ',up.last_name) as name, s.* from crm_user_subscription_history sh LEFT JOIN crm_subscription s ON s.id = sh.subscription_id LEFT JOIN crm_users_primary up on up.id = sh.user_id WHERE (s.plan_name LIKE '%$search%' OR s.plan_price LIKE '%$search%' OR s.plan_description LIKE '%$search%' OR sh.start_date LIKE '%$search%' OR sh.end_date LIKE '%$search%' OR sh.status LIKE '%$search%' OR sh.payment_mode LIKE '%$search%' OR sh.address LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT  sh.*, CONCAT(up.first_name,' ',up.last_name) as name, s.* from crm_user_subscription_history sh LEFT JOIN crm_subscription s ON s.id = sh.subscription_id LEFT JOIN crm_users_primary up on up.id = sh.user_id WHERE (s.plan_name LIKE '%$search%' OR s.plan_price LIKE '%$search%' OR s.plan_description LIKE '%$search%' OR sh.start_date LIKE '%$search%' OR sh.end_date LIKE '%$search%' OR sh.status LIKE '%$search%' OR sh.payment_mode LIKE '%$search%' OR sh.address LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}

