<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|



| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['purchased'] = 'member/store';
$route['withdraw'] = 'member/withdraw';
$route['withdraw_usd'] = 'member/withdraw/usd_index';
$route['dashboard'] = 'member/dashboard';
$route['ewallet'] = 'member/ewallet';
$route['active_pledge'] = 'member/pledge/active_pledge';
$route['pledge_history'] = 'member/pledge';
$route['resource'] = 'member/resource';
$route['register'] = 'user/signup';
$route['create_pledge'] = 'member/pledge/create_pledge';
$route['testimonial'] = 'member/testimonial';
$route['tree'] = 'member/tree_list';
$route['commission_report'] = 'member/report';
$route['profile'] = 'member/profile';
$route['referral'] = 'member/referral';
$route['joining_report'] = 'member/report/joining';
$route['buy_usd'] = 'member/buy_usd/index';
$route['buy_usd_request'] = 'member/buy_usd/request';
$route['call_coinpayment_api'] = 'member/buy_usd/call_coinpayment_api';
$route['transfer_view'] = 'member/transfer/add_view';
$route['transfer'] = 'member/transfer';
$route['edit_mtn'] = 'member/profile/edit_mtn_detail_jquery';
$route['eProducts'] = 'member/eproducts';
$route['exchange'] = 'member/exchange';
$route['exchange_history'] = 'member/exchange/exchange_history';
$route['subscription'] = 'member/subscription';
$route['readme_boame'] = 'member/subscription/readme';
$route['list_plan'] = 'member/subscription/list_plan';
$route['change_auto_subscription'] = 'member/subscription/change_auto_subscription';
$route['select_plan'] = 'member/subscription/select_subscription';
$route['exchange_ewallet'] = 'member/exchange/exchange_ewallet';
$route['verify_message'] = 'verification/verifyMessageJquery';
$route['pledge_view/(:num)'] = 'member/pledge/active_pledge_view/$1';
$route['pledge_report/(:num)'] = 'member/pledge/report/$1';
$route['view_address/(:num)'] = 'member/buy_usd/view/$1';
$route['pledge_rematch/(:num)'] = 'member/pledge/rematch/$1';
$route['pledge_confirm/(:num)'] = 'member/pledge/confim_payment_of_pledge/$1';
$route['view_pledge/(:num)'] = 'member/pledge/view/$1';
$route['pledge_details/(:num)'] = 'member/pledge/view_details/$1';
$route['pledge_complaint/(:num)'] = 'member/pledge/complaint/$1';
$route['ewallet/(:num)'] = '/member/ewallet/index/$1';
$route['contact'] = 'home/contact_us';
$route['opportunity'] = 'home/opportunity';
$route['home'] = 'home/index';
$route['howItWorks'] = 'home/how_it_work';
$route['login'] = 'home/login';
$route['news'] = 'home/view_all';
$route['boame_fx'] = 'home/boame_fx';
$route['single/(:num)'] = 'home/single/$1';
$route['expresspayment_done'] = 'home/expresspayment_done';
$route['expresspayment_posturl/(:any)'] = 'home/expresspayment_posturl/$1';
$route['translate_uri_dashes'] = FALSE;
