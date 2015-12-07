<?php 

$json_string = '';
if(isset($_POST['submit'])) {
    $params = array();
    $params['token'] = $_POST['token'];
    $params['pickup_datetime'] = $_POST['pickup_datetime'];
    $params['pickup_latitude'] = $_POST['pickup_latitude'];
    $params['pickup_longitude'] = $_POST['pickup_longitude'];
    $params['pickup_city_id'] = $_POST['pickup_city_id'];
    $params['service_type'] = $_POST['service_type'];
    $params['car_category_id'] = $_POST['car_category_id'];
    $params['destination_city_id'] = $_POST['destination_city_id'];
    $params['trip_type'] = $_POST['trip_type'];
    $params['no_of_days'] = $_POST['no_of_days'];
    $params['estimated_travelled_distance'] = $_POST['estimated_travelled_distance'];    
    
    if($_POST['environment'] == 'staging'){
        $api_url = "http://nstaging.api.myf.io/w/v1/json/supplier/search";
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
    $json_string = json_decode($json_string);

    $request_url = $api_url.'?'.http_build_query($postdata);
}

?>

<html>
    <head>
        <title>IXIGO - Search </title>
    </head>
    <body>
        <h1>Request</h1>
        <form method="post" action="search.php">
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
                    <td>(Optional)</td>
                </tr>                
                <tr>
                    <td>Destination City Id</td>
                    <td> : </td>
                    <td><input type="text" id="destination_city_id" name="destination_city_id" value=""></td>
                    <td>(Optional)</td>
                </tr>
                <tr>
                    <td>Trip Type</td>
                    <td> : </td>
                    <td><input type="text" id="trip_type" name="trip_type" value=""></td>
                    <td>(Optional)</td>
                </tr>
                <tr>
                    <td>No of Days</td>
                    <td> : </td>
                    <td><input type="text" id="no_of_days" name="no_of_days" value="2"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Estimated Traveled Distance</td>
                    <td> : </td>
                    <td><input type="text" id="estimated_travelled_distance" name="estimated_travelled_distance" value=""></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" id="submit" name="submit" value="Submit"></td>
                </tr>
            </table>                                                                                                
        </form>
        <h1>URL : </h1><?php echo $request_url; ?><br/>
        <h1>Response</h1>
        <?php echo "<pre>";print_r($json_string); ?>
    </body>
</html>
