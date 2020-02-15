<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News_m extends My_Model{

    protected $_table_name     = 'crm_news';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';

    function allnews($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_news');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
    function news_search($limit,$start,$search,$col,$dir)
    {
        $query = $this->db->like('id',$search)
                ->or_like('title',$search)
                ->or_like('description',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_news');
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function news_search_count($search)
    {
        $query = $this
                ->db
                ->like('id',$search)
                ->or_like('title',$search)
                ->or_like('description',$search)
                ->get('crm_news');
        return $query->num_rows();
    }  
}
