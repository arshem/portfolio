<h1>RescueGroups.org v1 API</h1>

<p>
	This is a script to show how to pull data from RescueGroups.org v1 API (their current only stable API release). 
	<ul>
		<li>apiget.php - Connects to the FTP server, downloads the files, and unzips them into date oriented folders</li>
		<li>apiallpets.php - This pulls in every animal from the full animal list. These are JSON files, one JSON "query" per line</li>
		<li>apinewpets.php - This pulls in JUST new pets from new pet JSON file(s). One JSON query per line</li>
		<li>apiorgs.php - This pulls new orgs into the database from the Org JSON file(s). One JSON query per line</li>
		<li>apiremovepets.php - This compares their CSV with "current" animals with the database. They provide only their active pets. You have to compare to the database to see which ones aren't in the CSV and remove them.</li>
		<li>apiupdatepets.php - This updates all pets in the JSON file.</li>
	</ul>
</p>