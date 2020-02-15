<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ewallet_m extends My_Model{

    protected $_table_name     = 'crm_ewallet_history';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
    
    public function all($limit,$start,$col,$dir)
    {
        $col = ($col == 'created') ? 'ceh.created' : $col;
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT ceh.id, CONCAT(cu.first_name,' ',cu.last_name) as name, ceh.created as edate, ceh.type, ceh.points from crm_ewallet_history ceh LEFT JOIN crm_users_primary cu on ceh.user_id = cu.id where ceh.user_id = $user_id ORDER BY $col $dir";
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

    function ewallet_search($limit,$start,$search,$col,$dir)
    {
        $col = ($col == 'created') ? 'ceh.created' : $col;
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT ceh.id, CONCAT(cu.first_name,' ',cu.last_name) as name, ceh.created as edate, ceh.type, ceh.points from crm_ewallet_history ceh LEFT JOIN crm_users_primary cu on ceh.user_id = cu.id where ceh.user_id = $user_id AND (cu.first_name LIKE '%".$search."%' OR cu.last_name LIKE '%".$search."%' OR ceh.type LIKE '%".$search."%' OR ceh.points LIKE '%".$search."%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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

    function ewallet_search_count($search)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT ceh.id, CONCAT(cu.first_name,' ',cu.last_name) as name, ceh.created as edate, ceh.type, ceh.points from crm_ewallet_history ceh LEFT JOIN crm_users_primary cu on ceh.user_id = cu.id where ceh.user_id = $user_id AND (cu.first_name LIKE '%".$search."%' OR cu.last_name LIKE '%".$search."%' OR ceh.type LIKE '%".$search."%' OR ceh.points LIKE '%".$search."%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}

