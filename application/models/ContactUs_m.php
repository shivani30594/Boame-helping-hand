<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ContactUs_m extends My_Model{
    protected $_table_name     = 'crm_contact_us';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;

    function all_inquirues($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_contact_us');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
    function inquiry_search($limit,$start,$search,$col,$dir)
    {
        $query = $this->db->like('id',$search)
                ->or_like('name',$search)
                ->or_like('email',$search)
                ->or_like('subject',$search)
                ->or_like('message',$search)
                ->or_like('created',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_contact_us');
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function inquiry_search_count($search)
    {
        $query = $this
                ->db
                ->like('id',$search)
                ->or_like('name',$search)
                ->or_like('email',$search)
                ->or_like('subject',$search)
                ->or_like('message',$search)
                ->or_like('created',$search)
                ->get('crm_contact_us');
        return $query->num_rows();
    }  
}
