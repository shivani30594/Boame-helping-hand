<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserPayment_m extends My_Model{

    protected $_table_name     = 'crm_user_payment';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    
    function all($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_user_payment');
        
        if($query->num_rows()>0)
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
        $query = $this->db->like('id',$search)
                ->or_like('amount',$search)
                ->or_like('status',$search)
                ->or_like('created_at',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_user_payment');
        if($query->num_rows()>0)
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
        $query = $this
                ->db
                ->like('id',$search)
                ->or_like('amount',$search)
                ->or_like('status',$search)
                ->or_like('created_at',$search)
                ->get('crm_user_payment');
        return $query->num_rows();
    } 
    
    function all_admin($limit,$start,$col,$dir)
    {   
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT pph.id, usr.first_name, usr.last_name, pph.amount, pph.created_at, ref.refferal_code,pph.status from crm_user_payment pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id ORDER BY pph.id desc LIMIT $limit OFFSET $start";
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
        $sql = "SELECT pph.id,usr.first_name, usr.last_name, pph.amount, pph.created_at, ref.refferal_code,pph.status from crm_user_payment pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE (pph.status = 'approved' OR pph.status = 'declined' OR pph.status = 'error' OR pph.status = 'pending' ) AND (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.amount LIKE '%$search%' OR ref.refferal_code LIKE '%$search%' OR pph.created_at LIKE '%$search%' OR pph.status LIKE '%$search%') ORDER BY pph.id desc LIMIT $limit OFFSET $start";
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
        $sql = "SELECT pph.id,usr.first_name, usr.last_name, pph.amount, pph.created_at, ref.refferal_code,pph.status from crm_user_payment pph LEFT JOIN crm_users_primary usr on pph.user_id = usr.id LEFT JOIN crm_refferal_details ref on usr.id = ref.user_id WHERE (pph.status = 'approved' OR pph.status = 'declined' OR pph.status = 'error' OR pph.status = 'pending' ) AND (usr.last_name LIKE '%$search%' OR usr.first_name LIKE '%$search%' OR pph.amount LIKE '%$search%' OR ref.refferal_code LIKE '%$search%' OR pph.created_at LIKE '%$search%' OR pph.status LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}
