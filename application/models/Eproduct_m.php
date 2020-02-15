<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Eproduct_m extends My_Model{

    protected $_table_name     = 'crm_eproducts';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';

    function allproducts($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_eproducts');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
    function product_search($limit,$start,$search,$col,$dir)
    {
        $query = $this->db->like('id',$search)
                ->or_like('product_name',$search)
                ->or_like('product_type',$search)
                ->or_like('download_link',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_eproducts');
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function product_search_count($search)
    {
        $query = $this
                ->db
                ->like('id',$search)
                ->or_like('product_name',$search)
                ->or_like('product_type',$search)
                ->or_like('download_link',$search)
                ->get('crm_eproducts');
        return $query->num_rows();
    }  
}
