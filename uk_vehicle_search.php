<?php
    if (!defined('ABSPATH'))exit;
    add_shortcode("ukvd_results_table", "ukvd_results_page");
    function ukvd_results_page() {
        
        $api_key = get_option('UKVD_API_Key');
        $uk_vehicle_reg = preg_replace('/\s+/', '', $_POST['UKVD_Vehicle_Registration']);
        $uk_vehicle_service = esc_attr( get_option('UKVD_SelectedPackage') );
        $qry_str = $uk_vehicle_service .'?' .'user_tag=WordPress&key_vrm='. $uk_vehicle_reg;
        
        $args = array('headers' => array('Authorization' => 'ukvd-ipwhitelist ' . $api_key ));
        $json = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://uk1.ukvehicledata.co.uk/api/datapackage/' . $qry_str, $args )), true);

        echo "<h3>";
        echo esc_attr(get_option('UKVD_Page_Heading'));
        echo "</h3>";
        if ($json["AuthenticationFailureDetails"]) {
            return $json["AuthenticationFailureDetails"]["Description"];
        }
        
        if (esc_attr( get_option('UKVD_SelectedPackage') ) == "MotHistoryData") {
            if ($json["Response"]["StatusCode"] == "ItemNotFound") {
                echo "No MOT Information Found for Vehicle.";
            }
            else {
                ?>
                <table>
                <?php
                if (esc_attr( get_option('UKVD_MotHistoryData_Make') ) == "on") {
                    ?>
                    <tr>
                        <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Make_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Make_Alias') ); } else { echo "Vehicle Manufacturer"; } ?>:</td>
                        <td><?php print($json["Response"]["DataItems"]["VehicleDetails"]["Make"]); ?></td>
                    </tr>
                    <?php
                }

                if (esc_attr( get_option('UKVD_MotHistoryData_Model') ) == "on") {
                    ?>
                    <tr>
                        <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Model_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Model_Alias') ); } else { echo "Vehicle Model"; } ?>:</td>
                        <td><?php print($json["Response"]["DataItems"]["VehicleDetails"]["Model"]); ?></td>
                    </tr>
                    <?php
                }

                if ($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["TestResult"] == "Pass") {
                    ?>
                    <tr>
                        <td>MOT Result:</td>
                        <td style="color:green;">Pass</td>
                    </tr>
                    <?php

                    if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Expiry') ) == "on") {
                        ?>
                        <tr>
                            <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Expiry_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Pass_Expiry_Alias') ); } else { echo "MOT Expiry Date"; } ?>:</td>
                            <td><?php print($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["ExpiryDate"]); ?></td>
                        </tr>
                        <?php
                    }

                    if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Odometer') ) == "on") {
                        ?>
                        <tr>
                            <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Odometer_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Pass_Odometer_Alias') ); } else { echo "Vehicle Odometer Reading"; } ?>:</td>
                            <td><?php print($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["OdometerReading"]); ?></td>
                        </tr>
                        <?php
                    }

                    if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Advisories') ) == "on") {

                        foreach ($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["AdvisoryNoticeList"] as $AdvisoryNotice) {
                            ?>
                            <tr>
                                <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Pass_Advisories_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Pass_Advisories_Alias') ); } else { echo "Advisory"; } ?>:</td>
                                <td><?php print($AdvisoryNotice); ?></td>
                            </tr>
                            <?php
                        }

                    }
                }

                if ($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["TestResult"] == "Fail") {
                    ?>
                    <tr>
                        <td>MOT Result:</td>
                        <td style="color:red;">Fail</td>
                    </tr>
                    <?php

                    if (esc_attr( get_option('UKVD_MotHistoryData_Fail_TestDate') ) == "on") {
                        ?>
                        <tr>
                            <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_TestDate_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Fail_TestDate_Alias') ); } else { echo "MOT Test Date"; } ?>:</td>
                            <td><?php print($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["TestDate"]); ?></td>
                        </tr>
                        <?php
                    }

                    if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Odometer') ) == "on") {
                        ?>
                        <tr>
                            <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Odometer_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Fail_Odometer_Alias') ); } else { echo "Vehicle Odometer Reading"; } ?>:</td>
                            <td><?php print($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["OdometerReading"]); ?></td>
                        </tr>
                        <?php
                    }

                    if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Advisories') ) == "on") {

                        foreach ($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["AdvisoryNoticeList"] as $AdvisoryNotice) {
                            ?>
                            <tr>
                                <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Advisories_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Fail_Advisories_Alias') ); } else { echo "Advisory"; } ?>:</td>
                                <td><?php print($AdvisoryNotice); ?></td>
                            </tr>
                            <?php
                        }

                    }

                    if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Reasons') ) == "on") {

                        foreach ($json["Response"]["DataItems"]["MotHistory"]["RecordList"][0]["FailureReasonList"] as $FailureReason) {
                            ?>
                            <tr>
                                <td><?php if (esc_attr( get_option('UKVD_MotHistoryData_Fail_Reasons_Alias') ) != "") { echo esc_attr( get_option('UKVD_MotHistoryData_Fail_Reasons_Alias') ); } else { echo "Failure Reason"; } ?>:</td>
                                <td><?php print($FailureReason); ?></td>
                            </tr>
                            <?php
                        }

                    }

                }

                ?>
                </table>
                <?php
            }
        }


        // Section to handle when set to Valuation Data
        if (esc_attr( get_option('UKVD_SelectedPackage') ) == "ValuationData") {
            if ($json["Response"]["StatusCode"] == "ItemNotFound") {
                echo "No Information Found for Vehicle.";
            }
            else {
            ?>
            <table>
            <?php
            if (esc_attr( get_option('UKVD_ValuationData_VehicleDescription') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_ValuationData_VehicleDescription_Alias') ) != "") { echo esc_attr( get_option('UKVD_ValuationData_VehicleDescription_Alias') ); } else { echo "Vehicle Description"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["VehicleDescription"]); ?></td>
                </tr>
                <?php
            }

            if (esc_attr( get_option('UKVD_ValuationData_Milage') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_ValuationData_Milage_Alias') ) != "") { echo esc_attr( get_option('UKVD_ValuationData_Milage_Alias') ); } else { echo "Valuation Mileage"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["Mileage"]); ?></td>
                </tr>
                <?php
            }

            if (esc_attr( get_option('UKVD_ValuationData_DealerForecourt') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_ValuationData_DealerForecourt_Alias') ) != "") { echo esc_attr( get_option('UKVD_ValuationData_DealerForecourt_Alias') ); } else { echo "Dealer Forecourt"; } ?>:</td>
                    <td>&pound;<?php print($json["Response"]["DataItems"]["ValuationList"]["Dealer forecourt"]); ?></td>
                </tr>
                <?php
            }

            if (esc_attr( get_option('UKVD_ValuationData_PrivateClean') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_ValuationData_PrivateClean_Alias') ) != "") { echo esc_attr( get_option('UKVD_ValuationData_PrivateClean_Alias') ); } else { echo "Private Clean"; } ?>:</td>
                    <td>&pound;<?php print($json["Response"]["DataItems"]["ValuationList"]["Private Clean"]); ?></td>
                </tr>
                <?php
            }

            if (esc_attr( get_option('UKVD_ValuationData_PartExchange') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_ValuationData_PartExchange_Alias') ) != "") { echo esc_attr( get_option('UKVD_ValuationData_PartExchange_Alias') ); } else { echo "Part Exchange"; } ?>:</td>
                    <td>&pound;<?php print($json["Response"]["DataItems"]["ValuationList"]["Part Exchange"]); ?></td>
                </tr>
                <?php
            }

            if (esc_attr( get_option('UKVD_ValuationData_PrivateAverage') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_ValuationData_PrivateAverage_Alias') ) != "") { echo esc_attr( get_option('UKVD_ValuationData_PrivateAverage_Alias') ); } else { echo "Private Average"; } ?>:</td>
                    <td>&pound;<?php print($json["Response"]["DataItems"]["ValuationList"]["Private Average"]); ?></td>
                </tr>
                <?php
            }

            if (esc_attr( get_option('UKVD_ValuationData_Auction') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_ValuationData_Auction_Alias') ) != "") { echo esc_attr( get_option('UKVD_ValuationData_Auction_Alias') ); } else { echo "Auction"; } ?>:</td>
                    <td>&pound;<?php print($json["Response"]["DataItems"]["ValuationList"]["Auction"]); ?></td>
                </tr>
                <?php
            }
            ?>
            </table>
            <?php
            }
        }



        // Section to handle when set to Vehicle Data
        if (esc_attr( get_option('UKVD_SelectedPackage') ) == "VehicleData") {
            if ($json["Response"]["StatusCode"] == "ItemNotFound") {
                echo "No Information Found for Vehicle.";
            }
            else {
            ?>
            <table>
            <?php
            if (esc_attr( get_option('UKVD_VehicleData_Make') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_Make_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_Make_Alias') ); } else { echo "Vehicle Manufacturer"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["VehicleRegistration"]["Make"]); ?></td>
                </tr>
                <?php
            }
            if (esc_attr( get_option('UKVD_VehicleData_Model') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_Model_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_Model_Alias') ); } else { echo "Vehicle Model"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["VehicleRegistration"]["Model"]); ?></td>
                </tr>
                <?php
            }
            if (esc_attr( get_option('UKVD_VehicleData_SizeCC') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_SizeCC_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_SizeCC_Alias') ); } else { echo "Vehicle Engine Size (cc)"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["VehicleRegistration"]["EngineCapacity"]); ?></td>
                </tr>
                <?php
            }
            if (esc_attr( get_option('UKVD_VehicleData_SizeL') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_SizeL_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_SizeL_Alias') ); } else { echo "Vehicle Engine Size (L)"; } ?>:</td>
                    <td><?php print(round($json["Response"]["DataItems"]["VehicleRegistration"]["EngineCapacity"] / 1000, 1)); ?></td>
                </tr>
                <?php
            }
            if (esc_attr( get_option('UKVD_VehicleData_Body') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_Body_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_Body_Alias') ); } else { echo "Vehicle Body Style"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["VehicleRegistration"]["DoorPlanLiteral"]); ?></td>
                </tr>
                <?php
            }
            if (esc_attr( get_option('UKVD_VehicleData_Fuel') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_Fuel_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_Fuel_Alias') ); } else { echo "Vehicle Fuel Type"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["VehicleRegistration"]["FuelType"]); ?></td>
                </tr>
                <?php
            }
            if (esc_attr( get_option('UKVD_VehicleData_Year') ) == "on") {

                // Calculate a user-readable datetime
                $date = date_create_from_format("Y-m-d\TH:i:s", $json["Response"]["DataItems"]["VehicleRegistration"]["DateFirstRegistered"]); 
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_Year_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_Year_Alias') ); } else { echo "Vehicle Date of Registration"; } ?>:</td>
                    <td><?php print(date_format($date, 'dS M Y')); ?></td>
                </tr>
                <?php
            }
            if (esc_attr( get_option('UKVD_VehicleData_Co2') ) == "on") {
                ?>
                <tr>
                    <td><?php if (esc_attr( get_option('UKVD_VehicleData_Co2_Alias') ) != "") { echo esc_attr( get_option('UKVD_VehicleData_Co2_Alias') ); } else { echo "Vehicle Co2 / Km"; } ?>:</td>
                    <td><?php print($json["Response"]["DataItems"]["VehicleRegistration"]["Co2Emissions"]); ?></td>
                </tr>
                <?php
            }
            ?>
            </table>
            <?php
            }
        }
        echo "<br/><hr/><br/>";
        echo esc_attr(get_option('UKVD_Page_Footer'));
        
        update_option("UKVD_LookupCounter", esc_attr( get_option('UKVD_LookupCounter') ) + 1);
        return;
    }

?>