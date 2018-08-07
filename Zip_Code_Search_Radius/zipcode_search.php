<?php
/****
	Zip code radial searching requires you to convert zip code to geo coordinates, do the maths based on miles selected, while doing a query to pull the other zip codes
	
	This assumes you have a zipcode & geo location MySQL table (see zipcodes.sql). This is using the CodeIgniter DB class. If unfamiliar with CodeIgniter DB class, it's pretty self explanatory. 

****/

if(is_numeric($_POST["zipcode"]) && isset($_POST["zipcode"])) {
	$this->db->select("latitude,longitude");
	$this->db->from("zipcodes");
	$this->db->where("zipcode",$_POST["zipcode"]);
	$this->db->limit(1);
	$result = $this->db->get();
	if($result->num_rows() == 1) {
		$geo = $result->row();
	}
	$radius = $this->db->escape_string($_POST["radius"]);

	$this->db->select("zipcode, ( 3959 * acos( cos( radians( {$geo['latitude']} ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( {$geo['longitude']} ) ) + sin( radians( {$geo['latitude']} ) ) * sin( radians( latitude ) ) ) ) AS distance");
	$this->db->from("zipcodes");
	$this->db->having("distance <= {$radius}");
	$this->db->order_by("distance","DESC");
	$zipcodes = $this->db->get();
	foreach($zipcodes->result() as $zips) {
		$data["zipcodes"][] = $zips;
	}
}

?>

