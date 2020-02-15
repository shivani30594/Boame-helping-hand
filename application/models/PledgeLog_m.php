<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PledgeLog_m extends My_Model{

    protected $_table_name     = 'crm_pledge_log';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = FALSE;

    public function allpledge($limit,$start,$col,$dir)
    {   
        $sql = "SELECT dq.id, wdq.created, wdq.pledge_title, pm.pledge_type, CONCAT(up.first_name,' ',up.last_name) as acceptores_name, dq.wants_to_donate_id FROM crm_donetores_queue dq LEFT JOIN crm_wants_to_donate_queue wdq on dq.wants_to_donate_id = wdq.id LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_users_primary up on dq.user_id = up.id WHERE dq.is_active = 'Y' AND dq.is_confirmed = 'N' ORDER BY $col $dir LIMIT $limit OFFSET $start ";
        // $sql = "SELECT wdq.created, pl.id, dq.wants_to_donate_id,CONCAT(up.first_name,' ',up.last_name) as acceptores_name, pl.start_date, pl.end_date, pl.is_confirmed, wdq.pledge_title, pm.pledge_type from crm_pledge_log pl LEFT JOIN crm_donetores_queue dq on pl.donetores_queue_id = dq.id  LEFT JOIN crm_users_primary up on pl.investor_id = up.id LEFT JOIN crm_wants_to_donate_queue wdq on wdq.id = dq.wants_to_donate_id LEFT JOIN crm_pledge_master pm on pm.id = wdq.pledge_type_id WHERE pl.is_confirmed = 'N' group by pl.donetores_queue_id ORDER BY pl.$col $dir";
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

    public function pledge_search($limit,$start,$search,$col,$dir)
    {   
        $sql = "SELECT dq.id, wdq.created, wdq.pledge_title, pm.pledge_type, CONCAT(up.first_name,' ',up.last_name) as acceptores_name, dq.wants_to_donate_id FROM crm_donetores_queue dq LEFT JOIN crm_wants_to_donate_queue wdq on dq.wants_to_donate_id = wdq.id LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_users_primary up on dq.user_id = up.id WHERE dq.is_active = 'Y' AND dq.is_confirmed = 'N' AND (up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%' OR up.mtn_mobile_number LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR wdq.pledge_title LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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

    public function pledge_search_count($search)
    {
        $user_id = $this->session->userdata('user_id');
        $sql = "SELECT dq.id, wdq.created, wdq.pledge_title, pm.pledge_type, CONCAT(up.first_name,' ',up.last_name) as acceptores_name, dq.wants_to_donate_id FROM crm_donetores_queue dq LEFT JOIN crm_wants_to_donate_queue wdq on dq.wants_to_donate_id = wdq.id LEFT JOIN crm_pledge_master pm on wdq.pledge_type_id = pm.id LEFT JOIN crm_users_primary up on dq.user_id = up.id WHERE dq.is_active = 'Y' AND dq.is_confirmed = 'N' AND (up.first_name LIKE '%$search%' OR up.last_name LIKE '%$search%' OR pm.pledge_type LIKE '%$search%' OR wdq.pledge_title LIKE '%$search%' OR up.mtn_mobile_number LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 
}

