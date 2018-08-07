<?php

if($_POST["id"] && $_POST["file"]) {

  $json = json_decode(file_get_contents("channels/".$_POST["file"]),true);
  $newJson = $json;
  $newJson["shortFormVideos"] = array();
  $newJson["lastUpdated"] = date("c");
  foreach($json["shortFormVideos"] as $key => $js) {
    if($_POST["id"] == $json["shortFormVideos"][$key]["id"]) {
      $new["id"] = $_POST["id"];
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
      $newJson["shortFormVideos"][$key] = $new;
    } else {
      $newJson["shortFormVideos"][$key] = $json["shortFormVideos"][$key];
    }
  }

  //echo json_encode($newJson);exit;
  file_put_contents("channels/".$_POST["file"], json_encode($newJson,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
  Header("Location: list.php?file=".$_POST["file"]);exit;
}
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>JSON Creator Roku</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom styles for this template -->

    <link href="style.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Roku JSON Creator</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="create.php">Create</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <?php 
      $json = json_decode(file_get_contents("channels/".$_GET["file"]));
      ?>
      <!-- Page Heading -->
      <h1 class="my-4"><?=$json->providerName;?></h1>
      <h5>Edit Video</h5>
      <hr>
      <?php 
      foreach($json->shortFormVideos as $js) {
          if($js->id == $_GET["id"]) {
            $values = $js;
          }
      }
      ?>
          <!-- Text input-->
    <form action="editVideo.php" method="POST">
      <input type="hidden" name="id" value="<?=$_GET["id"];?>" />
      <input type="hidden" name="file" value="<?=$_GET["file"];?>" />
      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Title</label>
          <input type="text" class="form-control" name="title" placeholder="Title" value="<?=$values->title;?>" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Genres</label>
          <?php
          $genres = "";
          foreach($values->genres as $genre) {
            $genres .= $genre.',';
          }
          ?>
          <input type="text" class="form-control" name="genres" placeholder="Comma Separated" value="<?=substr_replace($genres,"",-1);?>"required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Tags</label>
          <?php
          $tags = "";
          foreach($values->tags as $tag) {
            $tags .= $tag.',';
          }
          ?>
          <input type="text" class="form-control" name="tags" placeholder="Comma Separated" value="<?=substr_replace($tags,"",-1);?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Release Date</label>
          <input type="text" class="form-control" name="releaseDate" placeholder="yyyy-mm-dd" value="<?=$values->releaseDate;?>" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Date Added</label>
          <input type="text" class="form-control" name="dateAdded" placeholder="yyyy-mm-ddT##:##:##.###Z"  value="<?=$values->content->dateAdded;?>" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Thumbnail URL</label>
          <input type="text" class="form-control" name="thumbnail" placeholder="http://..."  value="<?=$values->thumbnail;?>" required>
        </div>  
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Video URL</label>
          <?php
          foreach($values->content->videos as $video) {
            $videos = $video;
          }
          ?>
          <input type="text" class="form-control" name="videos" placeholder="http://..."  value="<?=$videos->url;?>" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Duration</label>
          <input type="text" class="form-control" name="duration" placeholder="In Seconds" value="<?=$values->content->duration?>" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Ad Breaks</label>
          <?php
          $adBreak = "";
          foreach($values->content->adBreaks as $adBreaks) {
            $adBreak .= $adBreaks.",";
          }
          ?>
          <input type="text" class="form-control" name="adBreaks" placeholder="##:##,##:##,##:##" value="<?=substr_replace($adBreak,"",-1);?>" required>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Quality</label>
          <input type="text" class="form-control" name="quality" placeholder="HD" value="<?=$video->quality;?>"  required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Video Type</label>
          <input type="text" class="form-control" name="videoType" placeholder="MP4" value="<?=$video->videoType;?>" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Captions</label>
          <?php
          foreach($values->content->captions as $caption) {
            $captions = $caption;
          }?>
          <input type="text" class="form-control" name="captions" placeholder="http://..." value="<?=$captions;?>">
        </div>
      </div>
      <div class="form-row">
        <input type="submit" value="Add Video" class="btn btn-primary float-right" />
      </div>
    </form>
    <h5>Current View</h5>
 
      <div class="row">
        <div class="col-md-7">
          <img class="img-fluid rounded mb-3 mb-md-0" src="<?=$values->thumbnail;?>" alt="">
        </div>
        <div class="col-md-5">
          <h3><?=$values->title;?></h3>
          <p>
            Genres: <?=$genres;?><br />
            Tags: <?=$tags;?><br />
            Release Date: <?=$values->releaseDate;?><br />
          <p><?=$values->shortDescription;?></p>
        </div>
      </div>   

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Arshem Web Solutions 2018</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  </body>

</html>