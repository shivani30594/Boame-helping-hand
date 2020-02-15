<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TransferHistory_m extends My_Model{

    protected $_table_name     = 'crm_transfer_history';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
 
 	function all($limit,$start,$col,$dir)
    {   
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT th.id as id, th.transferred_points,th.type, th.transfer_date, up.first_name, up.last_name from crm_transfer_history th LEFT JOIN crm_users_primary up on up.id = th.sender_id  WHERE th.user_id = $user_id ORDER BY th.id $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT th.id as id, th.transferred_points,th.type, th.transfer_date, up.first_name, up.last_name from crm_transfer_history th LEFT JOIN crm_users_primary up on up.id = th.sender_id WHERE th.user_id = $user_id  AND (transferred_points LIKE '%$search%' OR transfer_date LIKE '%$search%' OR up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%') ORDER BY th.id $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT th.id as id,  th.transferred_points, th.type,th.transfer_date, up.first_name, up.last_name from crm_transfer_history th LEFT JOIN crm_users_primary up on up.id = th.sender_id WHERE th.user_id = $user_id  AND (transferred_points LIKE '%$search%' OR transfer_date LIKE '%$search%' OR up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    function all_debited($limit,$start,$col,$dir)
    {   
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT th.id as id, th.transferred_points,th.type, th.transfer_date, up.first_name, up.last_name from crm_transfer_history th LEFT JOIN crm_users_primary up on up.id = th.user_id  WHERE th.sender_id = $user_id ORDER BY th.id $dir LIMIT $limit OFFSET $start";
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
    
    function search_debited($limit,$start,$search,$col,$dir)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT th.id as id, th.transferred_points, th.type,th.transfer_date, up.first_name, up.last_name from crm_transfer_history th LEFT JOIN crm_users_primary up on up.id = th.user_id  WHERE th.sender_id = $user_id  AND (transferred_points LIKE '%$search%' OR transfer_date LIKE '%$search%' OR up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%') ORDER BY th.id $dir LIMIT $limit OFFSET $start";
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

    function search_count_debited($search)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT th.id as id,  th.transferred_points,th.type, th.transfer_date, up.first_name, up.last_name from crm_transfer_history th LEFT JOIN crm_users_primary up on up.id = th.user_id  WHERE th.sender_id = $user_id  AND (transferred_points LIKE '%$search%' OR transfer_date LIKE '%$search%' OR up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    function all_a($limit,$start,$col,$dir,$credited, $debited)
    {
        $sql = "SELECT * FROM crm_log where type ='".$credited."' OR type='".$debited."' ORDER BY $col $dir LIMIT $limit OFFSET $start";
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


    function search_debited_a($limit,$start,$search,$col,$dir, $credited, $debited)
    {
        $sql = "SELECT * FROM `crm_log` WHERE `type` IN ('".$credited."', '".$debited."') OR type LIKE '%$search%' OR message LIKE '%$search%' OR created LIKE '%$search%' ORDER BY $col $dir LIMIT $limit OFFSET $start";
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

    function search_count_debited_a($search, $credited, $debited)
    {
        $sql = "SELECT * FROM crm_log where `type` IN ('".$credited."', '".$debited."') OR type LIKE '%$search%' OR message LIKE '%$search%' OR created LIKE '%$search%'";
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
}