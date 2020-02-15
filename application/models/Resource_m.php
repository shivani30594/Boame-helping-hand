<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Resource_m extends My_Model{

    protected $_table_name     = 'crm_resources';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';

    function all($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_resources');
        
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
                ->or_like('type',$search)
                ->or_like('document_title',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_resources');
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
                ->or_like('type',$search)
                ->or_like('document_title',$search)
                ->get('crm_resources');
        return $query->num_rows();
    }  
}
