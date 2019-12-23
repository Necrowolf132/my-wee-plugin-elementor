<?php

/*
Plugin Name: Widgets de Elementor extra
Description: Plugin para extender los Widgets de Elementor con un menu de navegacion editable entre otras cosas 
Author: Jese Brito (Necrowolf)
Version:     1.0.0
Text Domain: my-elementor-extencion
*/
const WEE_DIR_PATH = __DIR__;
$wee_menu_title = "";
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// Include mfp-functions.php, use require_once to stop the script if mfp-functions.php is not found
require_once plugin_dir_path(__FILE__) . 'includes/wee_functions.php';

?>