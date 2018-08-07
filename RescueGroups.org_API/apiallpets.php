<?php
/*****

This file will get ALL pets from JSON files downloaded and unzipped from apiget.php
Usage: Cron Job Once a Week (probably more than necessary but I like fresh data)

****/


$files = array();
//Connect to MySQL Database
$conn_id = new mysqli("localhost","*************","*************","*************");

//Go through all JSON files
foreach(glob(date("mjY")."/APIKEY_pets_*.json") as $file) {
	$fp = file_get_contents($file);
	//Since not jalid JSON files, we have to break it all up
	$lines = explode(PHP_EOL,$fp);
	$sqlfields = "";
	foreach($lines as $line) {
		//Each Line is a JSON array
		$json = json_decode($line,ASSOC);
		$fields = array_keys($json);
		if(empty($sqlfields)) {
			foreach($fields as $field) {
				$sqlfields .= $field.", ";
			}
		}
		$values = "";
		foreach($json as $value) {
			if(is_array($value)) {
				$value = json_encode($value);
			}
			$values .= "'".$conn_id->escape_string($value)."', ";
		}
		//While not the "best" way to insert 90-100K pets, due to file limitations provided by data provider, this is the best we can do for now.
		$conn_id->query("INSERT INTO adopt_pets (".substr_replace($sqlfields,"",-2).") VALUES (".substr_replace($values,"",-2).")");
	}
	echo $file." Done";
}
exit;