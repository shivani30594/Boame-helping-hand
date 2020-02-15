<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class RefferalDetails_m extends My_Model{

    protected $_table_name     = 'crm_refferal_details';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;
    
}

