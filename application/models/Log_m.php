<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_m extends My_Model{

    protected $_table_name     = 'crm_log';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
    
     function all($limit,$start,$col,$dir)
    {   
        $sql = "SELECT * from crm_log ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_log WHERE (message LIKE '%$search%' OR type LIKE '%$search%' OR created LIKE '%$search%') ORDER BY $col $dir LIMIT $limit OFFSET $start";
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
        $sql = "SELECT * from crm_log WHERE (message LIKE '%$search%' OR type LIKE '%$search%' OR created LIKE '%$search%')";
        $query =  $this->db->query($sql);
        return $query->num_rows();
    } 

}

