<?php
/*****

This file will get ALL files from API's FTP server
Usage: Cron Job Once a Day [9AM ET is the best time]

****/

//Delete Existing API Files
$files = scandir("api_files");
foreach($files as $file) {
	if($file != ".." && $file != ".")
		unlink("api_files/".$file);
}

$api  = "APIKEY";
$host = "ftp.rescuegroups.org";
$user = "USERNAME";
$pass = "PASSWORD";

// FTP Connection
$fp = ftp_connect($host);
ftp_pasv($fp, true);
$login_result = ftp_login($fp, $user, $pass);
if((!$fp) || (!$login_result)) {
	die("FTP Login Failed, please check credentials");
}

//Download all files

$contents = ftp_nlist($fp,".");
foreach($contents as $content) {
    ftp_get($fp,"api_files/".$content,$content,FTP_BINARY);
}
ftp_close($fp);

//Make Sure directory has files
$files = array();
$files = scandir("api_files");
if(count($files) > 2) {
	$zip = new ZipArchive;
	foreach($files as $file) {
		if($zip->open("api_files/".$file)===TRUE) {
			$zip->extractTo(date("mjY").'/');
			$zip->close();
		}
	}
}

echo "Done\n";