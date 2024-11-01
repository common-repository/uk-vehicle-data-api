<?php
    if (!defined('ABSPATH')) exit;
    require(plugin_dir_path( __FILE__ ) .'uk_vehicle_options/UKVD_register_uk_vehicle_settings.php');
    require(plugin_dir_path( __FILE__ ) .'uk_vehicle_options/UKVD_uk_vehicle_create_menu.php');
    require(plugin_dir_path( __FILE__ ) .'uk_vehicle_options/UKVD_ValidateApiKey.php');
    add_action('init', 'UKVD_Download_User_Manual');
    function UKVD_Download_User_Manual() {
        if ($_GET['dum']==true && file_exists(plugin_dir_path( __FILE__ ) .'UKVDWPM.pdf')) {
            header("Content-type: application/octet-stream");
            header("Content-disposition: attachment;filename=UserManual.pdf");
            echo file_get_contents(plugin_dir_path( __FILE__ ) .'UKVDWPM.pdf');
        }
    }
    function UKVD_uk_vehicle_settings_page() {
        require(plugin_dir_path( __FILE__ ) .'uk_vehicle_options/UKVD_uk_vehicle_settings_page.php');
?>
    <div class="wrap">
    <h1>UK Vechicle Data - Plugin Configuration</h1>

        <h2 class="nav-tab-wrapper">
            <a href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('tab'=>'api'))); ?>' class="nav-tab <?php if($_GET["tab"]=="api") echo "nav-tab-active"; ?>">API Key Configuration</a>
            <a href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('tab'=>'spw'))); ?>' class="nav-tab <?php if($_GET["tab"]=="spw") echo "nav-tab-active"; ?>" <?php echo $Visible["SelectAllowedPackages"]; ?>>Single Package Table Widget</a>
            <a href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('tab'=>'scd'))); ?>' class="nav-tab <?php if($_GET["tab"]=="scd") echo "nav-tab-active"; ?>">Documentation</a>
        </h2>
        
        <form method="post" action="">
        <?php settings_fields( 'UKVD_Settings_Group' ); ?>
        <?php do_settings_sections( 'UKVD_Settings_Group' ); ?>
            
        <!-- API KEY TAB -->
        <?php if($_GET['tab']=='api') { ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        UKVD API Key<br/>
                        <small><a target="_blank" href="http://ukvehicledata.co.uk/">Click here to get an API Key</a></small>
                    </th>
                </tr>
                <tr>
                    <td>
                        <?php if (!UKVD_ValidateApiKey(sanitize_text_field($_POST["UKVD_API_Key"])) && isset($_POST["UKVD_API_Key"])) { ?><span style="color:red;">Unable to validate API Key, please try again.</span><?php } ?>
                        <input type="text" class="regular-text" name="UKVD_API_Key" value="<?php echo esc_attr( get_option('UKVD_API_Key') ); ?>" />
                    </td>
                    <td>
                    Total lookups using this key: <b><?php echo esc_attr( get_option('UKVD_LookupCounter') ); ?></b></td>
                </tr>
            </table>
        <?php } ?>
        <!-- END API KEY TAB -->
        
        <!-- SINGLE PACKAGE TABLE WIDGET TAB -->
        <?php if($_GET['tab']=='spw') { ?>
        <h2 class="nav-tab-wrapper">
            <a href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('SetPackage'=>'ValuationData'))); ?>' class="nav-tab <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "ValuationData") echo "nav-tab-active"; ?>" <?php echo $Visible["ValuationData"] ?>>Valuation Data</a>
            <a href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('SetPackage'=>'VehicleData'))); ?>' class="nav-tab <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "VehicleData") echo "nav-tab-active"; ?>" <?php echo $Visible["VehicleData"]; ?>>Vehicle Data</a>
            <a href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('SetPackage'=>'MotHistoryData'))); ?>' class="nav-tab <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "MotHistoryData") echo "nav-tab-active"; ?>" <?php echo $Visible["MotHistoryData"]; ?>>MOT History Data</a>
            <a href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('SetPackage'=>'ValuationCanPrice'))); ?>' class="nav-tab <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "ValuationCanPrice") echo "nav-tab-active"; ?>" <?php echo $Visible["ValuationCanPrice"]; ?>>Valuation CAN Data</a>
        </h2>

        <!-- DISPLAY VALUATION DATA TAB -->
        <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "ValuationData") { ?>
            <h2>Valuation Data</h2>
            <h4>You've selected Valuation Data to be displayed. Select which information you wish to display below.</h4>
            <div style="padding-left:10px;">
                        <input type="checkbox" name="UKVD_ValuationData_VehicleDescription" id="UKVD_ValuationData_VehicleDescription" <?php if (esc_attr( get_option('UKVD_ValuationData_VehicleDescription') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_ValuationData_VehicleDescription">Display Vehicle Description</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_ValuationData_VehicleDescription_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_ValuationData_VehicleDescription_Alias" id="UKVD_ValuationData_VehicleDescription_Alias" value="<?php echo esc_attr( get_option('UKVD_ValuationData_VehicleDescription_Alias') ); ?>">
                        </div>
                        
                        <input type="checkbox" name="UKVD_ValuationData_Milage" id="UKVD_ValuationData_Milage" <?php if (esc_attr( get_option('UKVD_ValuationData_Milage') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_ValuationData_Milage">Display Milage</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_ValuationData_Milage_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_ValuationData_Milage_Alias" id="UKVD_ValuationData_Milage_Alias" value="<?php echo esc_attr( get_option('UKVD_ValuationData_Milage_Alias') ); ?>">
                        </div>
                        
                        <input type="checkbox" name="UKVD_ValuationData_DealerForecourt" id="UKVD_ValuationData_DealerForecourt" <?php if (esc_attr( get_option('UKVD_ValuationData_DealerForecourt') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_ValuationData_DealerForecourt">Display Dealer Forecourt Price</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_ValuationData_DealerForecourt_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_ValuationData_DealerForecourt_Alias" id="UKVD_ValuationData_DealerForecourt_Alias" value="<?php echo esc_attr( get_option('UKVD_ValuationData_DealerForecourt_Alias') ); ?>">
                        </div>
                        
                        <input type="checkbox" name="UKVD_ValuationData_PrivateClean" id="UKVD_ValuationData_PrivateClean" <?php if (esc_attr( get_option('UKVD_ValuationData_PrivateClean') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_ValuationData_PrivateClean">Display Private Clean Price</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_ValuationData_PrivateClean_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_ValuationData_PrivateClean_Alias" id="UKVD_ValuationData_PrivateClean_Alias" value="<?php echo esc_attr( get_option('UKVD_ValuationData_PrivateClean_Alias') ); ?>">
                        </div>
                        
                        <input type="checkbox" name="UKVD_ValuationData_PartExchange" id="UKVD_ValuationData_PartExchange" <?php if (esc_attr( get_option('UKVD_ValuationData_PartExchange') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_ValuationData_PartExchange">Display Part Exchange Price</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_ValuationData_PartExchange_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_ValuationData_PartExchange_Alias" id="UKVD_ValuationData_PartExchange_Alias" value="<?php echo esc_attr( get_option('UKVD_ValuationData_PartExchange_Alias') ); ?>">
                        </div>
                        
                        <input type="checkbox" name="UKVD_ValuationData_PrivateAverage" id="UKVD_ValuationData_PrivateAverage" <?php if (esc_attr( get_option('UKVD_ValuationData_PrivateAverage') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_ValuationData_PrivateAverage">Display Private Average Price</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_ValuationData_PrivateAverage_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_ValuationData_PrivateAverage_Alias" id="UKVD_ValuationData_PrivateAverage_Alias" value="<?php echo esc_attr( get_option('UKVD_ValuationData_PrivateAverage_Alias') ); ?>">
                        </div>
                        
                        <input type="checkbox" name="UKVD_ValuationData_Auction" id="UKVD_ValuationData_Auction" <?php if (esc_attr( get_option('UKVD_ValuationData_Auction') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_ValuationData_Auction">Display Auction Price</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_ValuationData_Auction_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_ValuationData_Auction_Alias" id="UKVD_ValuationData_Auction_Alias" value="<?php echo esc_attr( get_option('UKVD_ValuationData_Auction_Alias') ); ?>">
                        </div>
                    </div>
        <?php } ?>
        <!-- END DISPLAY VALUATION DATA TAB -->
        
        <!-- DISPLAY VEHICLE DATA TAB -->
        <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "VehicleData") { ?>
            <h2>Vehicle Data</h2>
            <h4>You've selected Vehicle Data to be displayed. Select which information you wish to display below.</h4>
            <span style="margin-left:10px;">
                        <div style="padding-left:10px;">
                        <input type="checkbox" name="UKVD_VehicleData_Make" id="UKVD_VehicleData_Make"  <?php if (esc_attr( get_option('UKVD_VehicleData_Make') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_Make">Display Manufacturer</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_Make_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_Make_Alias" id="UKVD_VehicleData_Make_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_Make_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_VehicleData_Model" id="UKVD_VehicleData_Model"  <?php if (esc_attr( get_option('UKVD_VehicleData_Model') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_Model">Display Model</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_Model_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_Model_Alias" id="UKVD_VehicleData_Model_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_Model_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_VehicleData_SizeCC" id="UKVD_VehicleData_SizeCC"  <?php if (esc_attr( get_option('UKVD_VehicleData_SizeCC') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_SizeCC">Display Engine Size (cc)</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_SizeCC_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_SizeCC_Alias" id="UKVD_VehicleData_SizeCC_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_SizeCC_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_VehicleData_SizeL" id="UKVD_VehicleData_SizeL"  <?php if (esc_attr( get_option('UKVD_VehicleData_SizeL') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_SizeL">Display Engine Size (L)</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_SizeL_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_SizeL_Alias" id="UKVD_VehicleData_SizeL_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_SizeL_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_VehicleData_Body" id="UKVD_VehicleData_Body"  <?php if (esc_attr( get_option('UKVD_VehicleData_Body') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_Body">Display Body Style</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_Body_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_Body_Alias" id="UKVD_VehicleData_Body_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_Body_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_VehicleData_Fuel" id="UKVD_VehicleData_Fuel"  <?php if (esc_attr( get_option('UKVD_VehicleData_Fuel') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_Fuel">Display Fuel Type</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_Fuel_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_Fuel_Alias" id="UKVD_VehicleData_Fuel_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_Fuel_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_VehicleData_Year" id="UKVD_VehicleData_Year"  <?php if (esc_attr( get_option('UKVD_VehicleData_Year') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_Year">Display Year of Registration</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_Year_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_Year_Alias" id="UKVD_VehicleData_Year_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_Year_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_VehicleData_Co2" id="UKVD_VehicleData_Co2"  <?php if (esc_attr( get_option('UKVD_VehicleData_Co2') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_VehicleData_Co2">Display Co2/Km</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_VehicleData_Co2_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_VehicleData_Co2_Alias" id="UKVD_VehicleData_Co2_Alias" value="<?php echo esc_attr( get_option('UKVD_VehicleData_Co2_Alias') ); ?>">
                        </div>
                            
                    </div>
                    </span>
        <?php } ?>
        <!-- END DISPLAY VEHICLE DATA TAB -->
            
        <!-- DISPLAY MOT DATA TAB -->
        <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "MotHistoryData") { ?>
            <h2>MOT Data</h2>
            <h4>You've selected MOT Data to be displayed. Select which information you wish to display below.</h4>
            <span style="margin-left:10px;">
                        <div style="padding-left:10px;">
                        <input type="checkbox" name="UKVD_MotHistoryData_Make" id="UKVD_MotHistoryData_Make" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Make') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Make">Display Manufacturer</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Make_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Make_Alias" id="UKVD_MotHistoryData_Make_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Make_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_MotHistoryData_Model" id="UKVD_MotHistoryData_Model" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Model') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Model">Display Model</label><br/>
                        
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Model_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Model_Alias" id="UKVD_MotHistoryData_Model_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Model_Alias') ); ?>">
                        </div><Br/><Br/>
                            
                        <p><i>If MOT was "Pass";</i></p>
                            
                        <input type="checkbox" name="UKVD_MotHistoryData_Pass_Expiry" id="UKVD_MotHistoryData_Pass_Expiry" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Expiry') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Pass_Expiry">Display MOT Expiry Date</label><br/>
                            
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Pass_Expiry_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Pass_Expiry_Alias" id="UKVD_MotHistoryData_Pass_Expiry_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Pass_Expiry_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_MotHistoryData_Pass_Odometer" id="UKVD_MotHistoryData_Pass_Odometer" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Odometer') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Pass_Odometer">Display Vehicle Odometer Reading</label><br/>
                            
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Pass_Odometer_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Pass_Odometer_Alias" id="UKVD_MotHistoryData_Pass_Odometer_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Pass_Odometer_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_MotHistoryData_Pass_Advisories" id="UKVD_MotHistoryData_Pass_Advisories" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Advisories') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Pass_Advisories">Display Pass Advisories</label><br/>
                            
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Pass_Advisories_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Pass_Advisories_Alias" id="UKVD_MotHistoryData_Pass_Advisories_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Pass_Advisories_Alias') ); ?>">
                        </div><br/><Br/>
                            
                        <p><i>If MOT was "Fail";</i></p>
                            
                        <input type="checkbox" name="UKVD_MotHistoryData_Fail_TestDate" id="UKVD_MotHistoryData_Fail_TestDate" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_TestDate') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Fail_TestDate">Display MOT Test Date</label><br/>
                            
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Fail_TestDate_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Fail_TestDate_Alias" id="UKVD_MotHistoryData_Fail_TestDate_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Fail_TestDate_Alias') ); ?>">
                        </div>
                            
                        <input type="checkbox" name="UKVD_MotHistoryData_Fail_Odometer" id="UKVD_MotHistoryData_Fail_Odometer" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Odometer') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Fail_Odometer">Display Vehicle Odometer Reading</label><br/>
                            
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Fail_Odometer_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Fail_Odometer_Alias" id="UKVD_MotHistoryData_Fail_Odometer_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Fail_Odometer_Alias') ); ?>">
                        </div>    
                        
                        <input type="checkbox" name="UKVD_MotHistoryData_Fail_Advisories" id="UKVD_MotHistoryData_Fail_Advisories" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Advisories') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Fail_Advisories">Display Fail Advisories</label><br/>
                            
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Fail_Advisories_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Fail_Advisories_Alias" id="UKVD_MotHistoryData_Fail_Advisories_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Fail_Advisories_Alias') ); ?>">
                        </div>    
                        
                        <input type="checkbox" name="UKVD_MotHistoryData_Fail_Reasons" id="UKVD_MotHistoryData_Fail_Reasons" <?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Reasons') ) == "on") echo "checked"; ?>>
                        <label for="UKVD_MotHistoryData_Fail_Reasons">Display Fail Reasons</label><br/>
                            
                        <div style="padding-left:30px;">
                            <label for="UKVD_MotHistoryData_Fail_Reasons_Alias">Alias Text:</label>
                            <input type="text" name="UKVD_MotHistoryData_Fail_Reasons_Alias" id="UKVD_MotHistoryData_Fail_Reasons_Alias" value="<?php echo esc_attr( get_option('UKVD_MotHistoryData_Fail_Reasons_Alias') ); ?>">
                        </div> 
                    </div>
                    </span>
        <?php } ?>
        <!-- END DISPLAY MOT DATA TAB -->
            
        <!-- DISPLAY VALUATION CAN DATA TAB -->
        <?php if (esc_attr( get_option('UKVD_SelectedPackage') ) == "ValuationCanPrice") { ?>
            <h2>Valuation CAN Data</h2>
            <h4>You've selected Valuation CAN Data to be displayed. Select which information you wish to display below.</h4>
            <span style="margin-left:10px;">
                        <div style="padding-left:10px;">
                        <input type="checkbox" name="UKVD_ValuationCanPrice_Make" id="UKVD_ValuationCanPrice_Make">
                        <label for="UKVD_ValuationCanPrice_Make">Display Manufacturer</label><br/>
                        
                        <input type="checkbox" name="UKVD_ValuationCanPrice_Model" id="UKVD_ValuationCanPrice_Model">
                        <label for="UKVD_ValuationCanPrice_Model">Display Model</label><br/>
                        
                        <input type="checkbox" name="UKVD_ValuationCanPrice_SizeCC" id="UKVD_ValuationCanPrice_SizeCC">
                        <label for="UKVD_ValuationCanPrice_SizeCC">Display Engine Size (cc)</label><br/>
                        
                        <input type="checkbox" name="UKVD_ValuationCanPrice_SizeL" id="UKVD_ValuationCanPrice_SizeL">
                        <label for="UKVD_ValuationCanPrice_SizeL">Display Engine Size (L)</label><br/>
                        
                        <input type="checkbox" name="UKVD_ValuationCanPrice_Body" id="UKVD_ValuationCanPrice_Body">
                        <label for="UKVD_ValuationCanPrice_Body">Display Body Style</label><br/>
                        
                        <input type="checkbox" name="UKVD_ValuationCanPrice_Fuel" id="UKVD_ValuationCanPrice_Fuel">
                        <label for="UKVD_ValuationCanPrice_Fuel">Display Fuel Type</label><br/>
                        
                        <input type="checkbox" name="UKVD_ValuationCanPrice_Year" id="UKVD_ValuationCanPrice_Year">
                        <label for="UKVD_ValuationCanPrice_Year">Display Year of Registration</label><br/>
                        
                        <input type="checkbox" name="UKVD_ValuationCanPrice_Co2" id="UKVD_ValuationCanPrice_Co2">
                        <label for="UKVD_ValuationCanPrice_Co2">Display Co2/Km</label><br/>
                    </div>
                    </span>
        <?php } ?>
        <!-- END DISPLAY VALUATION CAN DATA TAB -->
        <hr/>
            <h3>Results Page Configuration</h3>
            <p>
                Following the guide in the setup manual found <a href='#'>here</a>, configure your results page here by including the Results Page Permalink along with a header and footer.
            </p>
            <table style="width:100%;">
                <tr>
                    <td>
                        <label for="UKVD_Widget_ActionLocation">Results Page Heading</label><br/>
                        <textarea name="UKVD_Page_Heading" style="width:100%; height:100px;" id="UKVD_Page_Heading"><?php echo esc_attr( get_option('UKVD_Page_Heading') ); ?></textarea>
                    </td>
                    <td>
                        <label for="UKVD_Widget_ActionLocation">Results Page Footer</label><br/>
                        <textarea name="UKVD_Page_Footer" style="width:100%; height:100px;" id="UKVD_Page_Footer"><?php echo esc_attr( get_option('UKVD_Page_Footer') ); ?></textarea>
                    </td>
                </tr>
            </table>
            <br/>
            <br/>
            <label for="UKVD_Widget_ActionLocation">Results Page Permalink: </label>
            <input style="width:50%;" type="text" name="UKVD_Widget_ActionLocation" id="UKVD_Widget_ActionLocation" value="<?php echo esc_attr( get_option('UKVD_Widget_ActionLocation') ); ?>">
        <?php } ?>
        <!-- END SINGLE PACKAGE TABLE WIDGET TAB -->
        
        <!-- API DOCUMENTATION PAGES TAB -->
        <?php if($_GET['tab']=='scd') { 
            if (!file_exists(plugin_dir_path( __FILE__ ) .'readme.txt'))
                print("Unable to locate Read Me file.");
            else {
        ?>
            <textarea disabled style="width:100%;height:70vh;"><?php
                print(file_get_contents(plugin_dir_path( __FILE__ ) .'readme.txt'));
            ?></textarea>
            <?php if (file_exists(plugin_dir_path( __FILE__ ) .'UKVDWPM.pdf')) { ?>
                <a target="_blank" href='<?php echo $_SERVER['PHP_SELF'] . "?" . http_build_query(array_merge($_GET, array('dum'=>true))); ?>' class="btn button-primary">Download PDF Manual</a>
            <?php } ?> 
        <?php } } ?>
        <!-- END API DOCUMENTATION PAGES TAB -->
        <?php 
            wp_nonce_field('admin-options');
            submit_button();
            settings_errors('UKVD_UKvehicle_messages');
        ?>
        
    </form>
</div>
<?php
    } 
?>