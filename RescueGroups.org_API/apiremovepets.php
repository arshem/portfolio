<?php
/*****

This file will DELETE ALL pets that are not listed in the CSV provided. This takes a HUGE amount of time because they provide every animal's ID that is still active. Would be better if they sent ONLY those to be removed. 

Usage: Cron Job Once a Day (This takes a LONG time (about 15-20 minutes). Please be warned!)

****/
$conn_id = new mysqli("localhost","*********","*************","************");
echo time()." - 1 \n";

//Check to see if the CSV exists. Known to "miss" days, causing a day with the entire table wrecked.
if(file_exists(date("mjY"."/APIKEY_petlist.csv"))) {
	$fp = str_replace(PHP_EOL,",",file_get_contents(date("mjY")."/APIKEY_petlist.csv"));
	echo time()." - 2 \n";

	$fp1 = array_filter(explode("," , $fp));
	//Number of Current Pets
	echo "CSV Pets:".count($fp1)."\n";


	$result = $conn_id->query("SELECT animalID FROM adopt_pets WHERE animalID");
	//Number of Pets in Table
	echo "DB Pets:".$result->num_rows."\n";
	$delete = array();
	echo time()." - 3 \n";

	while($row = $result->fetch_assoc()) {
	    if($row["animalID"]) {
	    	//Compare this animalID with the animalID in the CSV file
	        if(!in_array($row["animalID"],$fp1)) {
	            $delete[] = $row["animalID"];
	        }
	    }
	}
	echo time()." - 4 \n";

	$deleted = implode(",",$delete);

	echo time()." - 5 \n";
	printf("%d Pets Deleted.\n", count($delete));

	if(count($delete) > 0) {
	    $conn_id->query("DELETE FROM adopt_pets WHERE animalID IN (".$deleted.")");
	}
} else {
	echo "No CSV Founds";exit;
}
echo "Done";