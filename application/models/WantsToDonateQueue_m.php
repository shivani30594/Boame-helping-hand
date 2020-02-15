<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class WantsToDonateQueue_m extends My_Model{
    protected $_table_name     = 'crm_wants_to_donate_queue';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;

    function allpledge($limit,$start,$col,$dir)
    {   

    	$user_id = $this->session->userdata('user_id');
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id,dq.id as don_id, wdq.pledge_date, dq.start_date, dq.end_date,
        dq.is_confirmed FROM crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on 
        wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id 
        WHERE wdq.user_id = $user_id  ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
    function pledge_search($limit,$start,$search,$col,$dir)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id,dq.id as don_id, wdq.pledge_date, dq.start_date, dq.end_date,dq.is_confirmed
        FROM crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on 
        wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id 
        WHERE wdq.user_id = $user_id AND (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type 
        LIKE '%$search%' OR dq.start_date LIKE '%$search%' OR dq.end_date LIKE '%$search%' ) ORDER BY $col $dir LIMIT $limit OFFSET $start";
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

    function pledge_search_count($search)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id, dq.id as don_id,wdq.pledge_date, dq.start_date, dq.end_date,dq.is_confirmed
        FROM crm_wants_to_donate_queue wdq LEFT JOIN crm_pledge_master pm on 
        wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id 
        WHERE wdq.user_id = $user_id AND (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type 
        LIKE '%$search%' OR dq.start_date LIKE '%$search%' OR dq.end_date LIKE '%$search%' )";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

    function allpledge_a($limit,$start,$col,$dir)
    {   
        $sql = "SELECT CONCAT(up.first_name,' ',up.last_name) as name, wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date, wdq.is_confirmed  FROM crm_wants_to_donate_queue wdq LEFT JOIN crm_users_primary up on wdq.user_id = up.id LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id WHERE wdq.is_confirmed = 'N' ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
    function pledge_searc_a($limit,$start,$search,$col,$dir)
    {
        $sql = "SELECT CONCAT(up.first_name,' ',up.last_name) as name, wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date, wdq.is_confirmed  FROM crm_wants_to_donate_queue wdq LEFT JOIN crm_users_primary up on wdq.user_id = up.id LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id  WHERE (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%' ) AND wdq.is_confirmed = 'N' ORDER BY $col $dir LIMIT $limit OFFSET $start";
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

    function pledge_search_count_a($search)
    {
        $sql = "SELECT CONCAT(up.first_name,' ',up.last_name) as name, wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date, wdq.is_confirmed  FROM crm_wants_to_donate_queue wdq LEFT JOIN crm_users_primary up on wdq.user_id = up.id LEFT JOIN crm_pledge_master pm on  wdq.pledge_type_id = pm.id  WHERE (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%' )  AND wdq.is_confirmed = 'N'";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 


}

