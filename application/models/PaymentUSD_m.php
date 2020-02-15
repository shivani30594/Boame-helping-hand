<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentUSD_m extends My_Model{
    protected $_table_name     = 'crm_usd_payment';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;

    function all($limit,$start,$col,$dir)
    {   
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_usd_payment WHERE user_id = $user_id ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_usd_payment WHERE user_id = $user_id AND (status LIKE '%$search%' OR amount LIKE '%$search%' OR payment_date LIKE '%$search%' OR transaction_id LIKE '%$search%' OR address LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_usd_payment WHERE user_id = $user_id AND (status LIKE '%$search%' OR amount LIKE '%$search%' OR payment_date LIKE '%$search%' OR transaction_id LIKE '%$search%' OR address LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    
    function all_admin($limit,$start,$col,$dir)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT up.id, concat(usr.first_name, ' ', usr.last_name) as name,up.amount,up.transaction_id,up.address,up.created, up.status from crm_usd_payment up LEFT JOIN crm_users_primary usr on up.user_id = usr.id  ORDER BY $col $dir  LIMIT $limit OFFSET $start";
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
        $sql = "SELECT up.id, concat(usr.first_name, ' ', usr.last_name) as name,up.amount,up.transaction_id,up.address,up.created, up.status from crm_usd_payment up LEFT JOIN crm_users_primary usr on up.user_id = usr.id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR up.status LIKE '%$search%' OR up.created LIKE '%$search%' OR up.address LIKE '%$search%' OR up.transaction_id LIKE '%$search%' OR up.amount LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT up.id, concat(usr.first_name, ' ', usr.last_name) as name,up.amount,up.transaction_id,up.address,up.created, up.status from crm_usd_payment up LEFT JOIN crm_users_primary usr on up.user_id = usr.id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR up.status LIKE '%$search%' OR up.created LIKE '%$search%' OR up.address LIKE '%$search%' OR up.transaction_id LIKE '%$search%' OR up.amount LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}

