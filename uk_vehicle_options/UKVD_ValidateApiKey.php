<?php
if (!defined('ABSPATH')) exit;
function UKVD_ValidateApiKey($ApiKey) {
    $args = array('headers' => array('Authorization' => 'ukvd-ipwhitelist ' . $ApiKey ));
    $json = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://uk1.ukvehicledata.co.uk/api/datapackage/', $args )), true);
    foreach ($json["DataPackageList"] as $Package => $value) {
        return true;
    } 
    return false;    
}
?>