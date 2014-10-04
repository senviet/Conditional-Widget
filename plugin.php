<?php
/*
Plugin Name: Conditional Widget
Plugin URI: http://laptrinh.senviet.org
Description: Add display conditional for all widget
Version: 1.0
Author: thuytien
Author URI: http://nvduoc.senviet.org
*/

require_once dirname(__FILE__). '/CustomWidgetOption.php';

$custommer = CustomWidgetOption::getInstance();
$custommer->register();