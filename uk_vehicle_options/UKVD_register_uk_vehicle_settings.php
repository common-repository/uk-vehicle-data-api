<?php
if (!defined('ABSPATH')) exit;
function UKVD_register_uk_vehicle_settings() {
    // Global Settings
	register_setting( 'UKVD_Settings_Group', 'UKVD_API_Key' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_LookupCounter' );
    
    // Setting for the selected package
    register_setting( 'UKVD_Settings_Group', 'UKVD_SelectedPackage' );
    
    //MOT Data Settings
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Make' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Model' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Pass_Expiry' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Pass_Odometer' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Pass_Advisories' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_TestDate' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_Odometer' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_Advisories' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_Reasons' );
    
    //MOT Data Alias Settings
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Make_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Model_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Pass_Expiry_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Pass_Odometer_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Pass_Advisories_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_TestDate_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_Odometer_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_Advisories_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_MotHistoryData_Fail_Reasons_Alias' );
    
    //Valuation Data Settings
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_VehicleDescription' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_Milage' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_DealerForecourt' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_PrivateClean' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_PartExchange' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_PrivateAverage' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_Auction' );
    
    //Valuation Data Alias Settings
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_VehicleDescription_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_Milage_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_DealerForecourt_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_PrivateClean_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_PartExchange_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_PrivateAverage_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_ValuationData_Auction_Alias' );
    
    
    //Vehicle Data Settings
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Make' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Model' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_SizeCC' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_SizeL' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Body' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Fuel' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Year' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Co2' );
    
    //Vehicle Data Alias Settings
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Make_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Model_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_SizeCC_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_SizeL_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Body_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Fuel_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Year_Alias' );
    register_setting( 'UKVD_Settings_Group', 'UKVD_VehicleData_Co2_Alias' );
    
    //Widget Specific Settings
    register_setting( 'UKVD_Settings_Group', 'UKVD_Widget_ActionLocation');
    register_setting( 'UKVD_Settings_Group', 'UKVD_Page_Heading');
    register_setting( 'UKVD_Settings_Group', 'UKVD_Page_Footer');
}
?>