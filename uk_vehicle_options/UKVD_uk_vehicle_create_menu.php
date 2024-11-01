<?php
if (!defined('ABSPATH')) exit;
add_action('admin_menu', 'UKVD_uk_vehicle_create_menu');
function UKVD_uk_vehicle_create_menu() {
	add_menu_page('UKVD Plugin Options', 'UKVD Options', 'administrator', 'manage_options', 'UKVD_uk_vehicle_settings_page', 'dashicons-dashboard' );
	add_action( 'admin_init', 'UKVD_register_uk_vehicle_settings' );
}
?>