<?php
    if (!defined('ABSPATH')) exit;
    // Script for handling short codes.

    // Global Variables
    $ukvdReg = preg_replace('/\s+/', '', $_POST['UKVD_Vehicle_Registration']);
    $global;

    $api_key = get_option('UKVD_API_Key');
    $lookupData;

    // Shortcodes available
    add_shortcode("ukvd_getdataitem", 'ukvd_getdataitem');
    add_shortcode("ukvd_getbasicitem", 'ukvd_getbasicitem');
    add_shortcode("ukvd_searchbox", 'ukvd_searchbox');
    add_shortcode("ukvd_searchbutton", 'ukvd_searchbutton');
    
    function ukvd_searchbox($atts) {
        global $global;
        if ($global["ukvd_searchbox"])
            return;
        $_Settings = array(
                "results_permalink" => esc_attr( get_option('UKVD_Widget_ActionLocation') ),
                "styling" => 1,
                "placeholder" => "Registration",
                "buttontext" => "Search Now"
            );
        if ($atts["results_permalink"])
            $_Settings["results_permalink"] = $atts["results_permalink"];

        $searchBox = "
            <form action='" . $_Settings["results_permalink"] . "' method='post' id='ukvd_search_form'>
                <input name='UKVD_Vehicle_Registration' placeholder='" . $_Settings["placeholder"] . "' type='text'>
            </form>
        ";
        $global["ukvd_searchbox"] = true;
        return $searchBox;
    }
    function ukvd_searchbutton($atts) {
        global $global;
        if ($global["ukvd_searchbutton"])
            return;
        $_Settings = array(
                "buttontext" => "Search Now"
            );
        if ($atts["buttontext"])
            $_Settings["buttontext"] = $atts["buttontext"];
        $return = "
            <button id='btnPost' onClick='ukvd_submit_form()'>" . $_Settings["buttontext"] . "</button>
            <script type='text/javascript'>
                function ukvd_submit_form() {
                    document.getElementById('ukvd_search_form').submit();
                }
            </script>
        ";
        
        $global["ukvd_searchbutton"] = true;
        return $return;
    }

        function ukvd_getbasicitem($atts) {
            switch($atts["dataitem"]){
                case "make":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/Make"));
                    break;
                    
                case "model":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/Model"));
                    break;
                  
                case "colour":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/Colour"));
                    break;
                
                case "enginenumber":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/EngineNumber"));
                    break;
                
                case "enginesize":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/EngineCapacity")) . "cc";
                    break;
                    
                case "year":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/YearOfManufacture"));
                    break;
                    
                case "fuel":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/FuelType"));
                    break;
                    
                case "co2":
                    return ukvd_getdataitem(array("package"=>"VehicleData", "path"=>"Response/DataItems/VehicleRegistration/Co2Emissions"));
                    break;
                
                default:
                    return "Data Item not set.";
                    break;
            }
        }
    

    
        function ukvd_getdataitem($atts) {
            global $lookupData, $api_key, $ukvdReg;
            if (!$atts["return"])
                $atts["return"] = "string";
            if (!$atts["path"])
                return "No path set.";
            if (!$atts["package"])
                return "No package set.";
            if (!$lookupData[$atts["package"]])
            {
                $args = array('headers' => array('Authorization' => 'ukvd-ipwhitelist ' . $api_key ));
                $lookupData[$atts["package"]] = json_decode(wp_remote_retrieve_body(wp_remote_get( 'https://uk1.ukvehicledata.co.uk/api/datapackage/' . $atts["package"] .'?' .'user_tag=WordPress&key_vrm='. $ukvdReg, $args )), true);
                update_option("UKVD_LookupCounter", esc_attr( get_option('UKVD_LookupCounter') ) + 1);
            }
            $path = explode('/', $atts["path"]);
            $dataItem;
            for($i=0;$i<count($path);$i++) {
                if (!$dataItem)
                    $dataItem = $lookupData[$atts["package"]][$path[$i]];
                else
                    $dataItem = $dataItem[$path[$i]];            
                
                if ($atts["debug"] == true) {
                    print("Index: " . $i . " | Attribute: " . $path[$i] . " | Items: " . count($dataItem) . "<br><br>");
                    print_r($dataItem);
                    print("<br><br><hr><br>");
                }
            }
            
            // Return Types
            switch ($atts["return"]) {
                case "string":
                    if (!$dataItem)
                        return "";
                    return $dataItem;
                    break;
                case "list":
                    if (count($dataItem)==0)
                        return "<ul><li>No Data to Display.</li></ul>";
                    $return = "<ul>";
                    if (!$atts["maxitemlimit"])
                        $atts["maxitemlimit"] = 20;
                    for ($i=0;$i<count($dataItem);$i++) {
                        if ($i<$atts["maxitemlimit"])
                            $return = $return . "<li>" . $dataItem[$i] . "</li>";
                        if ($i==$atts["maxitemlimit"])
                            $return = $return . "<li style='color:red;'>List has been truncated</li>";
                    }
                    return $return . "</ul>";
                    break;
                case "money":
                    if (!$dataItem)
                        return "Unkown";
                    return "£" . $dataItem;
                    break;
                case "UKDateTime":
                    if (!$dataItem)
                        return "Unkown";
                    return date('j F Y H:i', strtotime($dataItem));
                    break;
            }
        }
    
   
?>