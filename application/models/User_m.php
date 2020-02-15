<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends My_Model{

    protected $_table_name     = 'crm_users_primary';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
 
 	public $rules = array(
        'email' => array(
            'field' => 'email',
            'label' => 'email',
            'rules' => 'trim|required'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        )

    );

    public function login($email, $password) 
    {
    	$this->db->where('password', $password);
    	$this->db->where('email', $email);
    	$user = $this->db->get('crm_users_primary')->row();
        if (count($user)) {
            if($user->is_email_verified == 0)
            {
                return 2;
            }
            $data = array(
                'email' => $user->email,
                'user_id' => $user->id,
                'loggedin' => TRUE,
            );

            $this->session->set_userdata($data);
            return TRUE;
        }
        return false;
    }

    function allusers($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->where('is_active','Y')
                ->where('is_mobile_verified','Y')
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_users_primary');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
    function user_search($limit,$start,$search,$col,$dir)
    {
        if ($search == 'male')
        {
            $query = "SELECT * FROM crm_users_primary WHERE gender = 'male' LIMIT $start , $limit";
            $query = $this->db->query($query);
        }
        else 
        {
             $query = $this->db->like('id',$search)
                ->where('is_active','Y')
                ->where('is_mobile_verified','Y')
                ->or_like('first_name',$search)
                ->or_like('last_name',$search)
                ->or_like('email',$search)
                ->or_like('mtn_mobile_number',$search)
                ->or_like('mtn_mobile_name',$search)
                ->or_like('gender',$search)
                ->or_like('created',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('crm_users_primary');
        }
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function user_search_count($search)
    {
        if ($search == 'male')
        {
            $query = "SELECT * FROM crm_users_primary WHERE gender = 'male'";
            $query = $this->db->query($query);
        }
        else 
        {
            $query = $this
                ->db
                ->where('is_active','Y')
                ->where('is_mobile_verified','Y')
                ->like('id',$search)
                ->or_like('first_name',$search)
                ->or_like('last_name',$search)
                ->or_like('email',$search)
                ->or_like('mtn_mobile_number',$search)
                ->or_like('mtn_mobile_name',$search)
                ->or_like('gender',$search)
                ->or_like('created',$search)
                ->get('crm_users_primary');
        }
        return $query->num_rows();
    }  

   
}

