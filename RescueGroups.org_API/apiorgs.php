<?php
/*****

This file will get ALL Orgs (Shelters & Rescues) from JSON files downloaded and unzipped from apiget.php
Usage: Cron Job Once a Day (10AM ET)

****/
$files = array();
$conn_id = new mysqli("localhost","**************","****************","*****************");


foreach(glob(date("mjY")."/APIKEY_orgs_*.json") as $file) {
	$fp = file_get_contents($file);
	$lines = explode(PHP_EOL,$fp);
	$sqlfields = "";
	foreach($lines as $line) {
		$json = json_decode($line,ASSOC);
		if(is_array($json)) {
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
    		$conn_id->query("INSERT INTO organizations (".substr_replace($sqlfields,"",-2).") VALUES (".substr_replace($values,"",-2).")");
		}
	}
	echo $file." Done";
}
exit;