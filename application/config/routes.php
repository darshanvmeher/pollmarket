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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'frontend';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['frontend'] = 'frontend/index';
$route['frontend/shop'] = 'frontend/shop';
$route['frontend/product/(:any)'] = 'frontend/product/$1';
$route['frontend/cart'] = 'frontend/cart';
$route['frontend/checkout'] = 'frontend/checkout';
$route['frontend/wishlist'] = 'frontend/wishlist';
$route['frontend/account'] = 'frontend/account';
$route['frontend/orders'] = 'frontend/orders';
$route['frontend/login'] = 'frontend/login';
$route['frontend/register'] = 'frontend/register';
$route['frontend/about'] = 'frontend/about';
$route['frontend/contact'] = 'frontend/contact';
$route['frontend/offers'] = 'frontend/offers';
$route['frontend/categories'] = 'frontend/categories';
$route['frontend/track-order'] = 'frontend/track_order';
$route['track-order'] = 'frontend/track_order';
//$route['track-order'] = 'frontend/track_order';
$route['frontend/faq'] = 'frontend/faq';
$route['frontend/bulk-buyers'] = 'frontend/bulk_buyers';

$route['admin'] = 'admin/index';
$route['admin/login'] = 'admin/login';
$route['admin/products'] = 'admin/products';
$route['admin/categories'] = 'admin/categories';
$route['admin/subcategories'] = 'admin/subcategories';
$route['admin/orders'] = 'admin/orders';
$route['admin/orders/(:num)'] = 'admin/order_detail/$1';
$route['admin/invoice'] = 'admin/invoice';
$route['admin/invoice/(:num)'] = 'admin/invoice/$1';
$route['admin/customers'] = 'admin/customers';
$route['admin/inventory'] = 'admin/inventory';
$route['admin/suppliers'] = 'admin/suppliers';
$route['admin/promotions'] = 'admin/promotions';
$route['admin/reports'] = 'admin/reports';
$route['admin/settings'] = 'admin/settings';
