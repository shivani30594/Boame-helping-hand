<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ExchangeHistory_m extends My_Model{

    protected $_table_name     = 'crm_exchange_history';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
    
    function all_admin($limit,$start,$col,$dir)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id, concat(usr.first_name, ' ' ,usr.last_name) as name, pph.exchage_amount, pph.getting_amount, pph.type, pph.created from crm_exchange_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id  ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT pph.id, concat(usr.first_name, ' ' ,usr.last_name) as name, pph.exchage_amount, pph.getting_amount, pph.type, pph.created from crm_exchange_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.exchage_amount LIKE '%$search%' OR pph.getting_amount LIKE '%$search%' OR pph.type LIKE '%$search%' OR pph.created LIKE '%$search%' ) ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT pph.id, concat(usr.first_name, ' ' ,usr.last_name) as name, pph.exchage_amount, pph.getting_amount, pph.type, pph.created from crm_exchange_history pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.exchage_amount LIKE '%$search%' OR pph.getting_amount LIKE '%$search%' OR pph.type LIKE '%$search%' OR pph.created LIKE '%$search%' )";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    function all($limit,$start,$col,$dir)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_exchange_history WHERE user_id =".$this->session->userdata('user_id')." ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_exchange_history WHERE user_id =".$this->session->userdata('user_id')." AND (exchage_amount LIKE '%$search%' OR getting_amount LIKE '%$search%' OR type LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_exchange_history WHERE user_id =".$this->session->userdata('user_id')." AND (exchage_amount LIKE '%$search%' OR getting_amount LIKE '%$search%' OR type LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 


}

