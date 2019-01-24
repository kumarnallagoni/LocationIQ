<?php

/*$curl = curl_init('https://us1.locationiq.com/v1/reverse.php?key=YOUR_PRIVATE_TOKEN&lat=-37.870662&lon=144.9803321&format=json');

curl_setopt_array($curl, array(
  CURLOPT_RETURNTRANSFER    =>  true,
  CURLOPT_FOLLOWLOCATION    =>  true,
  CURLOPT_MAXREDIRS         =>  10,
  CURLOPT_TIMEOUT           =>  30,
  CURLOPT_CUSTOMREQUEST     =>  'GET',
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}*/
?>


<!DOCTYPE html>
<html>
<form method="post">
<input type="text" name="address" placeholder="Enter Address">
<input type="submit" name="submit" value="submit">
</form>
</html>
<?php
if(isset($_POST['submit']))
{
function getLatLong($address){
if(!empty($address)){
//Formatted address
$formattedAddr = str_replace(' ','+',$address);
//Send request and receive json data by address
$geocodeFromAddr = file_get_contents
('https://us1.locationiq.com/v1/search.php?key=7788826d1f901c&q='.$formattedAddr.'&format=json');
//echo'<pre>';print_r($geocodeFromAddr);
$output = json_decode($geocodeFromAddr);
//echo'<pre>';print_r($output[0]);
//Get latitude and longitute from json data
//$data['latitude'] = $output[0]; 
$data['address1'] = $output[0]->display_name;
$data['latitude']=  $output[0]->lat;
$data['longitude'] = $output[0]->lon;
//Return latitude and longitude of the given address
if(!empty($data)){
return $data;
}else{
return false;
}
}else{
return false; 
}
}
$address = $_POST['address'];
$latLong = getLatLong($address);
$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';
$address1 =  $latLong['address1']?$latLong['address1']:'Not found';
echo "Address:".$address1."<br>";
echo "Latitude:".$latitude."<br>";
echo "longitude:".$longitude."";
}
?>

