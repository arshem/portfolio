<?php

if($_POST["file"]) {

  $json = json_decode(file_get_contents("channels/".$_POST["file"]),true);
  $newJson = $json;
  $newJson["lastUpdated"] = date("c");

  $new["id"] = trim(getGUID(),"{}");
  $new["title"] = $_POST["title"];
  $new["thumbnail"] = $_POST["thumbnail"];
  $new["genres"] = array_filter(explode(", ",$_POST["genres"]));
  $new["tags"] = array_filter(explode(", ",$_POST["tags"]));
  $new["releaseDate"] = $_POST["releaseDate"];
  $new["content"]["dateAdded"] = $_POST["dateAdded"];
  $new["content"]["captions"] = array_filter(explode(", ",$_POST["captions"]));
  $new["content"]["duration"] = $_POST["duration"];
  $new["content"]["adBreaks"] = array_filter(explode(", ",$_POST["adBreaks"]));
  $new["content"]["videos"][0]["url"] = $_POST["videos"];
  $new["content"]["videos"][0]["quality"] = $_POST["quality"];
  $new["content"]["videos"][0]["videoType"] = $_POST["videoType"];
  $newJson["shortFormVideos"][count($json["shortFormVideos"])] = $new;
  

  file_put_contents("channels/".$_POST["file"], json_encode($newJson,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
  Header("Location: list.php?file=".$_POST["file"]);exit;
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}
?>