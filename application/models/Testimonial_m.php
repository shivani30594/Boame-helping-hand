<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_m extends My_Model{
    protected $_table_name     = 'crm_testimonial';
    protected $_primary_key    = 'user_id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;

    function alltestimonials($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_testimonial');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
    function testimonial_search($limit,$start,$search,$col,$dir)
    {
        $query = $this->db->like('id',$search)
                ->or_like('full_name',$search)
                ->or_like('message',$search)
                ->or_like('image',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_testimonial');
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function testimonial_search_count($search)
    {
        $query = $this
                ->db
                ->like('id',$search)
                ->or_like('full_name',$search)
                ->or_like('image',$search)
                ->or_like('message',$search)
                ->get('crm_testimonial');
        return $query->num_rows();
    }  
}

