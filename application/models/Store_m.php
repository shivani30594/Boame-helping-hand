<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store_m extends My_Model{
    protected $_table_name     = 'crm_stores';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;
}
