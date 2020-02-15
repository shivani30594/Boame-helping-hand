<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DonatoresQueue_m extends My_Model{

    protected $_table_name     = 'crm_donetores_queue';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;

    /**
    * display all active pledge which are reflected in the datatable.
    */
    function active_allpledge($limit,$start,$col,$dir)
    {   
    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, dq.id, wdq.pledge_date FROM crm_wants_to_donate_queue wdq JOIN crm_pledge_master pm on  wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id WHERE wdq.user_id = $user_id AND wdq.is_confirmed = 'Y' AND pm.is_deleted = 'N' AND dq.is_confirmed = 'N' ORDER BY $col $dir LIMIT $limit OFFSET $start";
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

    /**
    * display serach pledge details
    */
    function active_pledge_search($limit,$start,$search,$col,$dir)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date FROM crm_wants_to_donate_queue wdq JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id WHERE wdq.user_id = $user_id AND pm.is_deleted = 'N' AND dq.is_confirmed = 'N' AND (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR wdq.pledge_title LIKE '%$search%' ) ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
    
    /**
    * Count the searchable result
    */
    function active_pledge_search_count($search)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date, dq.start_date, dq.end_date  FROM crm_wants_to_donate_queue wdq JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id  WHERE wdq.user_id = $user_id AND pm.is_deleted = 'N' AND (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR wdq.pledge_title LIKE '%$search%' ) AND dq.is_confirmed = 'N'";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}

