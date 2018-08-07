<?php
/*****

This file will get ALL NEW pets from JSON files downloaded and unzipped from apiget.php
Usage: Cron Job Once a Day (9:30 ET)

****/

$files = array();
$conn_id = new mysqli("localhost","**************","*************","****************");


foreach(glob(date("mjY")."/APIKEY_newpets_*.json") as $file) {
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
            //Normally only 3000-5000 new pets
    		$conn_id->query("INSERT INTO adopt_pets (".substr_replace($sqlfields,"",-2).") VALUES (".substr_replace($values,"",-2).")");
		}
	}
	echo $file." Done";
}
exit;