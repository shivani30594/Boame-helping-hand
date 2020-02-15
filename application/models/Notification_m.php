<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_m extends My_Model{
    protected $_table_name     = 'crm_notification';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_timestamps     = TRUE;
}
