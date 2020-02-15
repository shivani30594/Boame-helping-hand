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
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date, dq.start_date, dq.end_date FROM crm_wants_to_donate_queue wdq JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id WHERE wdq.user_id = $user_id AND wdq.is_confirmed = 'N' AND pm.is_deleted = 'N' ORDER BY $col $dir";
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
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date, dq.start_date, dq.end_date  FROM crm_wants_to_donate_queue wdq JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id  WHERE wdq.user_id = $user_id AND wdq.is_confirmed = 'N' AND pm.is_deleted = 'N' AND (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR dq.start_date LIKE '%$search%' OR dq.end_date LIKE '%$search%' ) ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT wdq.pledge_title, pm.pledge_type, wdq.id, wdq.pledge_date, dq.start_date, dq.end_date  FROM crm_wants_to_donate_queue wdq JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_donetores_queue dq on wdq.id = dq.wants_to_donate_id  WHERE wdq.user_id = $user_id AND wdq.is_confirmed = 'N' AND pm.is_deleted = 'N' AND (wdq.pledge_title LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR dq.start_date LIKE '%$search%' OR dq.end_date LIKE '%$search%' )";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}

