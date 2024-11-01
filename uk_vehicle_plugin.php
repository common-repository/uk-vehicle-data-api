<?php

if (!defined('ABSPATH'))exit;
    /*
    Plugin Name: UK Vehicle Data API
    Plugin URI:  https://ukvehicledata.co.uk/ApiDocumentation
    Description: The UK Vehicle Data API Plugin allows you to provide a VRM lookup facility on your site.
    Version:     2.0.0
    Author:      UK Vehicle Data
    Author URI:  https://ukvehicledata.co.uk/
    License:     GPL2

    UK Vehicle Data WordPress Plugin is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.

    UK Vehicle Data WordPress Plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with UK Vehicle Data WordPress Plugin. If not, see https://www.gnu.org/licenses/gpl.txt.
    */
    if ( !defined('ABSPATH') ) {
        die("-1");   
    }
    
    require_once('uk_vehicle_widget.php');
    require_once('uk_vehicle_options.php');
    require_once('uk_vehicle_search.php');
    require_once('uk_vehicle_shortcodes.php');

    
    
    

    add_action( 'wp_enqueue_scripts', 'UKVD_uk_vehicle_plugin_script' );// end jquery
    add_action( 'wp_enqueue_scripts', 'plugin_assets' );
    function plugin_assets() {
	   wp_enqueue_style( 'style', plugin_dir_url( __FILE__ ) . 'uk_vehicle_style.css' );
    }
?>
