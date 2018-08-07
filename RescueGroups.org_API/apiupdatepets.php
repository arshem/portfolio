<?php
/*****

This file will UPDATE pets from JSON files downloaded and unzipped from apiget.php
Usage: Cron Job Once a Day (10:30AM ET)

****/
$files = array();
$conn_id = new mysqli("localhost","**************","***************","*************");

foreach(glob(date("mjY")."/APIKEY_updatedpets_*.json") as $file) {
	$fp = file_get_contents($file);
	$lines = explode(PHP_EOL,$fp);
	$sqlfields = "";
	foreach($lines as $line) {
		$json = json_decode($line,ASSOC);
		$set = "";
		if(is_array($json)) {
			foreach($json as $key => $value) {
				if(is_array($value)) {
					$value = json_encode($value);
				}
				$set .= $key."='".$conn_id->escape_string($value)."', ";
			}
			$conn_id->query("UPDATE adopt_pets SET ".substr_replace($set,"",-2)." WHERE animalID=".$json["animalID"]);
		}
	}

echo $file." Done";
}



exit;