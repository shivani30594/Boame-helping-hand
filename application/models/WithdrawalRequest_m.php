<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WithdrawalRequest_m extends My_Model{

    protected $_table_name     = 'crm_withdrawal_request';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
 
 	function all($limit,$start,$col,$dir, $type)
    {   
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT * from crm_withdrawal_request WHERE user_id = $user_id AND type='$type' ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_withdrawal_request WHERE  user_id = $user_id AND type='$type' AND (received_amount LIKE '%$search%' OR withdraw_amount LIKE '%$search%' OR withdraw_date LIKE '%$search%' OR is_withdraw LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_withdrawal_request WHERE user_id = $user_id AND type='$type' AND (received_amount LIKE '%$search%' OR withdraw_amount LIKE '%$search%' OR withdraw_date LIKE '%$search%' OR is_withdraw LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 


    function all_admin($limit,$start,$col,$dir)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id, usr.first_name, usr.last_name,usr.mtn_mobile_number, usr.mtn_mobile_name,pph.withdraw_amount,pph.received_amount, pph.withdraw_date,pph.is_withdraw from crm_withdrawal_request pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id  ORDER BY $col $dir  LIMIT $limit OFFSET $start";
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
        $sql = "SELECT pph.id, usr.first_name, usr.last_name,usr.mtn_mobile_number,usr.mtn_mobile_name, pph.withdraw_amount,pph.received_amount, pph.withdraw_date ,pph.is_withdraw from crm_withdrawal_request pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.withdraw_amount LIKE '%$search%' OR pph.withdraw_date LIKE '%$search%' OR pph.is_withdraw LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT pph.id, usr.first_name, usr.last_name, usr.mtn_mobile_number,usr.mtn_mobile_name,pph.withdraw_amount,pph.received_amount, pph.withdraw_date,pph.is_withdraw  from crm_withdrawal_request pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.withdraw_amount LIKE '%$search%' OR pph.withdraw_date LIKE '%$search%' OR pph.is_withdraw LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    function all_cancel_admin($limit,$start,$col,$dir,$status,$type)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.address,pph.id, usr.first_name, usr.last_name,usr.mtn_mobile_number,usr.mtn_mobile_name, pph.withdraw_amount,pph.received_amount, pph.withdraw_date,pph.is_withdraw from crm_withdrawal_request pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE pph.type= '$type' AND pph.is_withdraw = '".$status."' ORDER BY $col $dir  LIMIT $limit OFFSET $start";
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
    
    function search_cancel_admin($limit,$start,$search,$col,$dir,$status,$type)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.address,pph.id, pph.id, usr.first_name, usr.last_name,usr.mtn_mobile_number,usr.mtn_mobile_name, pph.withdraw_amount,pph.received_amount, pph.withdraw_date ,pph.is_withdraw from crm_withdrawal_request pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE pph.type= '$type' AND pph.is_withdraw = '".$status."' AND (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.received_amount LIKE '%$search%' OR pph.withdraw_amount LIKE '%$search%' OR pph.withdraw_date LIKE '%$search%' OR pph.is_withdraw LIKE '%$search%' OR usr.mtn_mobile_name LIKE '%$search%' OR usr.mtn_mobile_number LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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

    function search_cancel_count_admin($search,$status,$type)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.address,pph.id,pph.id, usr.first_name, usr.last_name, usr.mtn_mobile_number,usr.mtn_mobile_name,pph.withdraw_amount,pph.received_amount, pph.withdraw_date,pph.is_withdraw  from crm_withdrawal_request pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id WHERE pph.type= '$type' AND pph.is_withdraw = '".$status."' AND (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.received_amount LIKE '%$search%' OR pph.withdraw_amount LIKE '%$search%' OR pph.withdraw_date LIKE '%$search%' OR pph.is_withdraw LIKE '%$search%' OR usr.mtn_mobile_name LIKE '%$search%' OR usr.mtn_mobile_number LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    
}