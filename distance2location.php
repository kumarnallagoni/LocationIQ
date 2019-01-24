<!DOCTYPE html>
<html>
<form method="post">
<input type="text" name="addressFrom" placeholder="Enter From Address"><br>
<input type="text" name="addressTo" placeholder="Enter To Address">

<input type="submit" name="submit" value="submit">
</form>
</html>

<?php
if (isset($_POST['submit'])) {

function getDistance($addressFrom, $addressTo, $unit = ''){
    // Google API key
    $apiKey = '7788826d1f901c';
    
    // Change address format
    $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo     = str_replace(' ', '+', $addressTo);
    
    // Geocoding API request with start address
    $geocodeFrom = file_get_contents('https://us1.locationiq.com/v1/search.php?key='.$apiKey.'&q='.$formattedAddrFrom.'&format=json');
    $outputFrom = json_decode($geocodeFrom);
    //echo '<pre>';print_r($outputFrom);
    if(!empty($outputFrom->error_message)){
        return $outputFrom->error_message;
    }
    
    // Geocoding API request with end address
    $geocodeTo = file_get_contents('https://us1.locationiq.com/v1/search.php?key='.$apiKey.'&q='.$formattedAddrTo.'&format=json');
    $outputTo = json_decode($geocodeTo);
    if(!empty($outputTo->error_message)){
        return $outputTo->error_message;
    }
    
    // Get latitude and longitude from the geodata
    echo '<br> From Address Details';
    echo '<br>Location------'.$addrFrom = $outputFrom[0]->display_name;
    echo '<br>Latitude ------'. $latitudeFrom    = $outputFrom[0]->lat;
    echo '<br>Longitude--------- '.$longitudeFrom    = $outputFrom[0]->lon;
    echo '<br>*****************************************************************';
    echo '<br> To Address Details';
    echo '<br>Location----------'.$addrTo = $outputTo[0]->display_name;
    echo '<br>Latitude ----------'.$latitudeTo        = $outputTo[0]->lat;
    echo '<br>Longitude------------'.$longitudeTo    = $outputTo[0]->lon;
    
    // Calculate distance between latitude and longitude
    $theta    = $longitudeFrom - $longitudeTo;
    $dist    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
    $dist    = acos($dist);
    $dist    = rad2deg($dist);
    echo '<br>Miles between Locations-------------'.$miles    = $dist * 60 * 1.1515;
    
    // Convert unit and return distance
    $unit = strtoupper($unit);
    if($unit == "K"){
        return round($miles * 1.609344, 2).' km';
    }elseif($unit == "M"){
        return round($miles * 1609.344, 2).' meters';
    }else{
        return round($miles, 2).' miles';
    }
}
$addressFrom = $_POST['addressFrom'];
$addressTo = $_POST['addressTo'];
$distance =  getDistance($addressFrom, $addressTo, 'M');


}
?>
