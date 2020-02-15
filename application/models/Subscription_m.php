<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_m extends My_Model{

    protected $_table_name     = 'crm_subscription';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;

    function all($limit,$start,$col,$dir)
    {   
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_subscription ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_subscription WHERE (plan_name LIKE '%$search%' OR plan_duration LIKE '%$search%' OR plan_description LIKE '%$search%' OR plan_price_currency LIKE '%$search%' OR created LIKE '%$search%' OR plan_price LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_subscription WHERE (plan_name LIKE '%$search%' OR plan_duration LIKE '%$search%' OR plan_description LIKE '%$search%' OR plan_price_currency LIKE '%$search%' OR created LIKE '%$search%' OR plan_price LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}