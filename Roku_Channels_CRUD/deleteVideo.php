<?php

if($_GET["file"] && $_GET["id"]) {
  $json = json_decode(file_get_contents("channels/".$_GET["file"]),true);
  $newJson = $json;
  $newJson["shortFormVideos"] = array();
  $newJson["lastUpdated"] = date("c");
  foreach($json["shortFormVideos"] as $key => $js) {
    if($_GET["id"] == $json["shortFormVideos"][$key]["id"]) {

    } else {
      $newJson["shortFormVideos"][$key] = $json["shortFormVideos"][$key];
    }
  }
  file_put_contents("channels/".$_GET["file"], json_encode($newJson,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
}

  Header("Location: list.php?file=".$_GET["file"]);exit;
