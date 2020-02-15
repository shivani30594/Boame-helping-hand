<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserSecondary_m extends My_Model
{
    protected $_table_name     = 'crm_users_secondary';
    protected $_primary_key    = 'user_id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;
}

