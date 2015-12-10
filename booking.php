<?php 

$json_string = '';
if(isset($_POST['submit'])) {
    $params = array();
    $params['token'] = $_POST['token'];    
    $params['traveler_id'] = $_POST['traveler_id'];
    $params['traveler_name'] = $_POST['traveler_name'];
    $params['traveler_email_id'] = $_POST['traveler_email_id'];
    $params['traveler_mobile_no'] = $_POST['traveler_mobile_no'];    
    $params['pickup_datetime'] = $_POST['pickup_datetime'];
    $params['pickup_latitude'] = $_POST['pickup_latitude'];
    $params['pickup_longitude'] = $_POST['pickup_longitude'];
    $params['pickup_city_id'] = $_POST['pickup_city_id'];
    $params['service_type'] = $_POST['service_type'];
    $params['car_category_id'] = $_POST['car_category_id'];
    $params['destination_city_id'] = $_POST['destination_city_id'];
    $params['trip_type'] = $_POST['trip_type'];    
    $params['pickup_area'] = $_POST['pickup_area'];
    
    if(!empty($_POST['supplier_ids'])){
        $supplierIds = explode(',',$_POST['supplier_ids']);
        $params['supplier_ids'] = json_encode($supplierIds);
    }
    
    $params['package_rate'] = $_POST['package_rate'];
    $params['per_km_rate'] = $_POST['per_km_rate'];    
    $params['pickup_address'] = $_POST['pickup_address'];
    $params['drop_area'] = $_POST['drop_area'];
    $params['drop_address'] = $_POST['drop_address'];    
    $params['no_of_days'] = $_POST['no_of_days'];
    $params['estimated_travelled_distance'] = $_POST['estimated_travelled_distance'];    
    $params['booking_acceptance_time_limit'] = $_POST['booking_acceptance_time_limit'];
    
    if(!empty($_POST['via_city_list'])){
        $viaCityList = explode(",",$_POST['via_city_list']);
        $params['via_city_list'] = json_encode($viaCityList);            
    }       

    if($_POST['environment'] == 'staging'){
        $api_url = "http://nstaging.api.myf.io/w/v1/json/supplier/booking";
        $securitySalt = $_POST['security_salt'];
    }
    
    $par = json_encode($params);
    $hash_string = $par.'||'.$securitySalt;
    $newhash = strtolower(hash('sha512', $hash_string));

    $postdata = array();
    $postdata['parameters'] = $par;
    $postdata['rqid'] = $newhash;
    
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $api_url);
    curl_setopt($curl_handle, CURLOPT_POST, true);
    curl_setopt($curl_handle, CURLOPT_ENCODING, "gzip");
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query($postdata));
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    $json_string = curl_exec($curl_handle);   
    
    $request_url = $api_url.'?'.http_build_query($postdata);
}

?>

<html>
    <head>
        <title>IXIGO - Booking </title>
    </head>
    <body>
        <h1>Request</h1>
        <form method="post" action="booking.php">
            <table>
                <tr>
                    <td>Environment </td>
                    <td> : </td>
                    <td><select id="environment" name="environment" >
                            <option value="staging">Staging</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Token</td>
                    <td> : </td>
                    <td><input type="text" id="token" name="token" value=""></td>
                    <td></td>
                </tr> 
                <tr>
                    <td>Security Salt</td>
                    <td> : </td>
                    <td><input type="text" id="security_salt" name="security_salt" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Traveler Id</td>
                    <td> : </td>
                    <td><input type="text" id="traveler_id" name="traveler_id" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Traveler Name</td>
                    <td> : </td>
                    <td><input type="text" id="traveler_name" name="traveler_name" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Traveler Email Id</td>
                    <td> : </td>
                    <td><input type="text" id="traveler_email_id" name="traveler_email_id" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Traveler Mobile No</td>
                    <td> : </td>
                    <td><input type="text" id="traveler_mobile_no" name="traveler_mobile_no" value=""></td>
                    <td></td>
                </tr>                
                <tr>
                    <td>Pickup Datetime</td>
                    <td> : </td>
                    <td><input type="text" id="pickup_datetime" name="pickup_datetime" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pickup Latitude</td>
                    <td> : </td>
                    <td><input type="text" id="pickup_latitude" name="pickup_latitude" value=""><br/></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pickup Longitude</td>
                    <td> : </td>
                    <td><input type="text" id="pickup_longitude" name="pickup_longitude" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pickup City Id</td>
                    <td> : </td>
                    <td><input type="text" id="pickup_city_id" name="pickup_city_id" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Service Type</td>
                    <td> : </td>
                    <td><input type="text" id="service_type" name="service_type" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Car Category Id</td>
                    <td> : </td>
                    <td><input type="text" id="car_category_id" name="car_category_id" value=""></td>
                    <td></td>
                </tr>                
                <tr>
                    <td>Destination City Id</td>
                    <td> : </td>
                    <td><input type="text" id="destination_city_id" name="destination_city_id" value=""></td>
                    <td>(Outstation - Optional)</td>
                </tr>
                <tr>
                    <td>Trip Type</td>
                    <td> : </td>
                    <td><input type="text" id="trip_type" name="trip_type" value=""></td>
                    <td></td>
                </tr>                
                <tr>
                    <td>pickup Area</td>
                    <td> : </td>
                    <td><input type="text" id="pickup_area" name="pickup_area" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Supplier Ids</td>
                    <td> : </td>
                    <td><input type="text" id="supplier_ids" name="supplier_ids" value=""></td>
                    <td>(Commas separated ids)</td>
                </tr>
                <tr>
                    <td>Package Rate</td>
                    <td> : </td>
                    <td><input type="text" id="package_rate" name="package_rate" value=""></td>
                    <td>(For Outstation Package)</td>
                </tr>
                <tr>
                    <td>Per Km Rate</td>
                    <td> : </td>
                    <td><input type="text" id="per_km_rate" name="per_km_rate" value=""></td>
                    <td>(For Outstation)</td>
                </tr>
                <tr>
                    <td>Pickup Address</td>
                    <td> : </td>
                    <td><input type="text" id="pickup_address" name="pickup_address" value=""></td>
                    <td>(Optional)</td>
                </tr>
                <tr>
                    <td>Drop Area</td>
                    <td> : </td>
                    <td><input type="text" id="drop_area" name="drop_area" value=""></td>
                    <td>(Optional)</td>
                </tr>
                <tr>
                    <td>Drop Address</td>
                    <td> : </td>
                    <td><input type="text" id="drop_address" name="drop_address" value=""></td>
                    <td>(Optional)</td>
                </tr>                
                <tr>
                    <td>No of Days</td>
                    <td> : </td>
                    <td><input type="text" id="no_of_days" name="no_of_days" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Estimated Traveled Distance</td>
                    <td> : </td>
                    <td><input type="text" id="estimated_travelled_distance" name="estimated_travelled_distance" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Booking Acceptance Time Limit</td>
                    <td> : </td>
                    <td><input type="text" id="booking_acceptance_time_limit" name="booking_acceptance_time_limit" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Via City List</td>
                    <td> : </td>
                    <td><input type="text" id="via_city_list" name="via_city_list" value=""></td>
                    <td>(Optional - Commas separated ids)</td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="submit" name="submit" value="Submit"></td>
                </tr>
            </table>                                                                                                
        </form>
        <h1>URL : </h1><?php echo $request_url; ?><br/>
        <h1>Response</h1>
        <?php echo $json_string; ?>
    </body>
</html>
