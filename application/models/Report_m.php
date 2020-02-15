<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_m extends My_Model{

    protected $_table_name     = 'crm_report_user';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
 
 	function all($limit,$start,$col,$dir)
    {   
        $sql = "SELECT ru.id, ru.created, concat(pm.first_name, pm.last_name) reported_by,concat(pmm.first_name, pmm.last_name) reported_to, ru.report_comment, ru.transaction_id FROM `crm_report_user` ru LEFT JOIN crm_users_primary pm on ru.`report_by_id` = pm.id LEFT JOIN crm_users_primary pmm on ru.`report_to_id` = pmm.id ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT ru.id, ru.created, concat(pm.first_name, pm.last_name) reported_by,concat(pmm.first_name, pmm.last_name) reported_to, ru.report_comment, ru.transaction_id FROM `crm_report_user` ru LEFT JOIN crm_users_primary pm on ru.`report_by_id` = pm.id LEFT JOIN crm_users_primary pmm on ru.`report_to_id` = pmm.id Where (pmm.first_name LIKE '%$search%' OR pm.first_name LIKE '%$search%' OR pm.last_name LIKE '%$search%' OR pmm.last_name LIKE '%$search%' OR ru.transaction_id LIKE '%$search%' OR ru.report_comment LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT ru.id, ru.created, concat(pm.first_name, pm.last_name) reported_by,concat(pmm.first_name, pmm.last_name) reported_to, ru.report_comment, ru.transaction_id FROM `crm_report_user` ru LEFT JOIN crm_users_primary pm on ru.`report_by_id` = pm.id LEFT JOIN crm_users_primary pmm on ru.`report_to_id` = pmm.id Where (pmm.first_name LIKE '%$search%' OR pm.first_name LIKE '%$search%' OR pm.last_name LIKE '%$search%' OR pmm.last_name LIKE '%$search%' OR ru.transaction_id LIKE '%$search%' OR ru.report_comment LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

}