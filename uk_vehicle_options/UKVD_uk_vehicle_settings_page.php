  <?php
if (!defined('ABSPATH')) exit;
    // Check if the user is an administrator.
    if( !current_user_can('administrator') )
        die ("Your user is not an administrator.");
    if (!isset($_GET['tab'])) $_GET['tab'] = 'api';
                               
    if (esc_attr( get_option('UKVD_LookupCounter') ) == "") update_option("UKVD_LookupCounter", 0);
    // Setting for the selected package
        if (isset($_GET["SetPackage"])) update_option("UKVD_SelectedPackage", sanitize_text_field($_GET["SetPackage"]));
    
    if (isset($_POST['submit'])) { 
        // Verify User
        check_admin_referer('admin-options');
        
        if (UKVD_ValidateApiKey(sanitize_key($_POST["UKVD_API_Key"]))) {
            if ($_POST["UKVD_API_Key"] != esc_attr( get_option('UKVD_API_Key') )) update_option("UKVD_LookupCounter", 0);
            update_option("UKVD_API_Key", sanitize_key($_POST["UKVD_API_Key"]));
        }
        
        
        
        // Settings for the Widget Spifically
        update_option("UKVD_Widget_ActionLocation", sanitize_text_field($_POST["UKVD_Widget_ActionLocation"]));
        update_option("UKVD_Page_Heading", sanitize_text_field($_POST["UKVD_Page_Heading"]));
        update_option("UKVD_Page_Footer", sanitize_text_field($_POST["UKVD_Page_Footer"]));
        
        // Settings for the selected MOT Data options
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Make"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Make"]))
            update_option("UKVD_MotHistoryData_Make", sanitize_text_field($_POST["UKVD_MotHistoryData_Make"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Model"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Model"]))
            update_option("UKVD_MotHistoryData_Model", sanitize_text_field($_POST["UKVD_MotHistoryData_Model"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Expiry"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Pass_Expiry"]))
            update_option("UKVD_MotHistoryData_Pass_Expiry", sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Expiry"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Odometer"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Pass_Odometer"]))
            update_option("UKVD_MotHistoryData_Pass_Odometer", sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Odometer"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Advisories"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Pass_Advisories"]))
            update_option("UKVD_MotHistoryData_Pass_Advisories", sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Advisories"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_TestDate"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Fail_TestDate"]))
            update_option("UKVD_MotHistoryData_Fail_TestDate", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_TestDate"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Odometer"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Fail_Odometer"]))
            update_option("UKVD_MotHistoryData_Fail_Odometer", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Odometer"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Advisories"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Fail_Advisories"]))
            update_option("UKVD_MotHistoryData_Fail_Advisories", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Advisories"]));
        if (sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Reasons"]) == "on" || !isset($_POST["UKVD_MotHistoryData_Fail_Reasons"]))
            update_option("UKVD_MotHistoryData_Fail_Reasons", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Reasons"]));
        
        // Settings for the selected MOT Data alias
            update_option("UKVD_MotHistoryData_Make_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Make_Alias"]));
            update_option("UKVD_MotHistoryData_Model_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Model_Alias"]));
            update_option("UKVD_MotHistoryData_Pass_Expiry_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Expiry_Alias"]));
            update_option("UKVD_MotHistoryData_Pass_Odometer_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Odometer_Alias"]));
            update_option("UKVD_MotHistoryData_Pass_Advisories_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Pass_Advisories_Alias"]));
            update_option("UKVD_MotHistoryData_Fail_TestDate_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_TestDate_Alias"]));
            update_option("UKVD_MotHistoryData_Fail_Odometer_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Odometer_Alias"]));
            update_option("UKVD_MotHistoryData_Fail_Advisories_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Advisories_Alias"]));
            update_option("UKVD_MotHistoryData_Fail_Reasons_Alias", sanitize_text_field($_POST["UKVD_MotHistoryData_Fail_Reasons_Alias"]));
        
        // Settings for the selected valuation data options
        if (sanitize_text_field($_POST["UKVD_ValuationData_VehicleDescription"]) == "on" || !isset($_POST["UKVD_ValuationData_VehicleDescription"]))
            update_option("UKVD_ValuationData_VehicleDescription", sanitize_text_field($_POST["UKVD_ValuationData_VehicleDescription"]));
        if (sanitize_text_field($_POST["UKVD_ValuationData_Milage"]) == "on" || !isset($_POST["UKVD_ValuationData_Milage"]))
            update_option("UKVD_ValuationData_Milage", sanitize_text_field($_POST["UKVD_ValuationData_Milage"]));
        if (sanitize_text_field($_POST["UKVD_ValuationData_DealerForecourt"]) == "on" || !isset($_POST["UKVD_ValuationData_DealerForecourt"]))
            update_option("UKVD_ValuationData_DealerForecourt", sanitize_text_field($_POST["UKVD_ValuationData_DealerForecourt"]));
        if (sanitize_text_field($_POST["UKVD_ValuationData_PrivateClean"]) == "on" || !isset($_POST["UKVD_ValuationData_PrivateClean"]))
            update_option("UKVD_ValuationData_PrivateClean", sanitize_text_field($_POST["UKVD_ValuationData_PrivateClean"]));
        if (sanitize_text_field($_POST["UKVD_ValuationData_PartExchange"]) == "on" || !isset($_POST["UKVD_ValuationData_PartExchange"]))
            update_option("UKVD_ValuationData_PartExchange", sanitize_text_field($_POST["UKVD_ValuationData_PartExchange"]));
        if (sanitize_text_field($_POST["UKVD_ValuationData_PrivateAverage"]) == "on" || !isset($_POST["UKVD_ValuationData_PrivateAverage"]))
            update_option("UKVD_ValuationData_PrivateAverage", sanitize_text_field($_POST["UKVD_ValuationData_PrivateAverage"]));
        if (sanitize_text_field($_POST["UKVD_ValuationData_Auction"]) == "on" || !isset($_POST["UKVD_ValuationData_Auction"]))
            update_option("UKVD_ValuationData_Auction", sanitize_text_field($_POST["UKVD_ValuationData_Auction"]));
        
        // Settings for the selected valuation data alias
            update_option("UKVD_ValuationData_VehicleDescription_Alias", sanitize_text_field($_POST["UKVD_ValuationData_VehicleDescription_Alias"]));
            update_option("UKVD_ValuationData_Milage_Alias", sanitize_text_field($_POST["UKVD_ValuationData_Milage_Alias"]));
            update_option("UKVD_ValuationData_DealerForecourt_Alias", sanitize_text_field($_POST["UKVD_ValuationData_DealerForecourt_Alias"]));
            update_option("UKVD_ValuationData_PrivateClean_Alias", sanitize_text_field($_POST["UKVD_ValuationData_PrivateClean_Alias"]));
            update_option("UKVD_ValuationData_PartExchange_Alias", sanitize_text_field($_POST["UKVD_ValuationData_PartExchange_Alias"]));
            update_option("UKVD_ValuationData_PrivateAverage_Alias", sanitize_text_field($_POST["UKVD_ValuationData_PrivateAverage_Alias"]));
            update_option("UKVD_ValuationData_Auction_Alias", sanitize_text_field($_POST["UKVD_ValuationData_Auction_Alias"]));
        
        // Settings for the selected vehicle data options
            update_option("UKVD_VehicleData_Make", sanitize_text_field($_POST["UKVD_VehicleData_Make"]));
            update_option("UKVD_VehicleData_Model", sanitize_text_field($_POST["UKVD_VehicleData_Model"]));
            update_option("UKVD_VehicleData_SizeCC", sanitize_text_field($_POST["UKVD_VehicleData_SizeCC"]));
            update_option("UKVD_VehicleData_SizeL", sanitize_text_field($_POST["UKVD_VehicleData_SizeL"]));
            update_option("UKVD_VehicleData_Body", sanitize_text_field($_POST["UKVD_VehicleData_Body"]));
            update_option("UKVD_VehicleData_Fuel", sanitize_text_field($_POST["UKVD_VehicleData_Fuel"]));
            update_option("UKVD_VehicleData_Year", sanitize_text_field($_POST["UKVD_VehicleData_Year"]));
            update_option("UKVD_VehicleData_Co2", sanitize_text_field($_POST["UKVD_VehicleData_Co2"]));
        
        // Settings for the selected vehicle data alias
            update_option("UKVD_VehicleData_Make_Alias", sanitize_text_field($_POST["UKVD_VehicleData_Make_Alias"]));
            update_option("UKVD_VehicleData_Model_Alias", sanitize_text_field($_POST["UKVD_VehicleData_Model_Alias"]));
            update_option("UKVD_VehicleData_SizeCC_Alias", sanitize_text_field($_POST["UKVD_VehicleData_SizeCC_Alias"]));
            update_option("UKVD_VehicleData_SizeL_Alias", sanitize_text_field($_POST["UKVD_VehicleData_SizeL_Alias"]));
            update_option("UKVD_VehicleData_Body_Alias", sanitize_text_field($_POST["UKVD_VehicleData_Body_Alias"]));
            update_option("UKVD_VehicleData_Fuel_Alias", sanitize_text_field($_POST["UKVD_VehicleData_Fuel_Alias"]));
            update_option("UKVD_VehicleData_Year_Alias", sanitize_text_field($_POST["UKVD_VehicleData_Year_Alias"]));
            update_option("UKVD_VehicleData_Co2_Alias", sanitize_text_field($_POST["UKVD_VehicleData_Co2_Alias"]));
        
        add_settings_error('UKVD_UKvehicle_messages', 'UKvehicle_message', __('Settings Saved', 'UKVD_UKvehicle'), 'updated'); 
    }
    
    
    // Section to get keys by API code.
    $api_key = get_option('UKVD_API_Key');
    $args = array('headers' => array('Authorization' => 'ukvd-ipwhitelist ' . $api_key ));
    $json = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://uk1.ukvehicledata.co.uk/api/datapackage/', $args )), true);

    $Visible["ValuationData"] = "style='display:none;'";
    $Visible["VehicleData"] = "style='display:none;'";
    $Visible["MotHistoryData"] = "style='display:none;'";
    $Visible["ValuationCanPrice"] = "style='display:none;'";
    $Visible["SelectAllowedPackages"] = "style='display:none;'";
    
    foreach ($json["DataPackageList"] as $Package => $value) {
        $Visible[$value["NameTag"]] = "";
        $Visible["SelectAllowedPackages"] = "";
    }   
?>