<?php

function distance($lat1, $lon1, $lat2, $lon2) {

  $theta = $lon1 - $lon2;
  $dist = rad2deg(acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta))));
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  return $miles;

}

$CTLat = (float) 41.6000;
$CTLong = (float) 72.7000;

$MALat = (float) 42.3000;
$MALong = (float) 71.8000;

$NYLat = (float) 40.6700;
$NYLong = (float) 73.9400;

$ip = $_SERVER['REMOTE_ADDR'];

$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

$currLongAndLat = explode(',', $details->loc);

	if ($currLongAndLat[0] < 0){
		$CurrLat = (float) substr($currLongAndLat[0], 1, 6);
	}
	else{
		$CurrLat = (float) substr($currLongAndLat[0], 0, 6);
	}

	if ($currLongAndLat[1] < 0){
		$CurrLong = (float) substr($currLongAndLat[1], 1, 6);
	}
	else{
		$CurrLong = (float) substr($currLongAndLat[1], 0, 6);
	}
	
$CADistance = substr(distance($CurrLat, $CurrLong, $CALat, $CALong), 0, 6);
$CTDistance = substr(distance($CurrLat, $CurrLong, $CTLat, $CTLong), 0, 6);
$MADistance = substr(distance($CurrLat, $CurrLong, $MALat, $MALong), 0, 6);
$NYDistance = substr(distance($CurrLat, $CurrLong, $NYLat, $NYLong), 0, 6);


if(($CADistance < 800) || ($CTDistance < 800) || ($MADistance < 800) || ($NYDistance < 800)){
	echo "These seminars are available near you:<br>";
	if($CADistance < 800){
		echo "California {$CADistance} Miles away<br>";
	}
	if($CTDistance < 800){
		echo "Connecticut {$CTDistance} Miles away<br>";
	}
	if($MADistance < 800){
		echo "Massachusetts {$MADistance} Miles away<br>";
	}
	if($NYDistance < 800){
		echo "New York {$NYDistance} Miles away<br>";
	}
}
else{
	echo "Sorry, there doesn't seem to be anything in your area.";
}

