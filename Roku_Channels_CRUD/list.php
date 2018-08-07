<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Arshem Web Solutions">

    <title>JSON Creator Roku</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Custom styles for this template -->

    <link href="style.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">Roku JSON Creator</a>
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
      <h5>Add Videos</h5>
      <hr>

          <!-- Text input-->
    <form method="POST" action="createVideo.php">
      <input type="hidden" name="file" value="<?=$_GET["file"];?>" />
      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Title</label>
          <input type="text" class="form-control" name="title" placeholder="Title" value="" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Genres</label>
          <input type="text" class="form-control" name="genres" placeholder="Comma Separated" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Tags</label>
          <input type="text" class="form-control" name="tags" placeholder="Comma Separated" required>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Release Date</label>
          <input type="text" class="form-control" name="releaseDate" placeholder="yyyy-mm-dd" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Date Added</label>
          <input type="text" class="form-control" name="dateAdded" placeholder="yyyy-mm-ddT##:##:##.###Z" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Thumbnail URL</label>
          <input type="text" class="form-control" name="thumbnail" placeholder="http://..." required>
        </div>  
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Video URL</label>
          <input type="text" class="form-control" name="videos" placeholder="http://..." required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Duration</label>
          <input type="text" class="form-control" name="duration" placeholder="In Seconds" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Ad Breaks</label>
          <input type="text" class="form-control" name="adBreaks" placeholder="##:##,##:##,##:##" required>
        </div>
      </div>

      <div class="form-row">
        <div class="col-md-4 mb-3">
          <label>Quality</label>
          <input type="text" class="form-control" name="quality" placeholder="HD" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Video Type</label>
          <input type="text" class="form-control" name="videoType" placeholder="MP4" required>
        </div>
        <div class="col-md-4 mb-3">
          <label>Captions</label>
          <input type="text" class="form-control" name="captions" placeholder="http://..." >
        </div>
      </div>
      <div class="form-row">
        <input type="submit" value="Add Video" class="btn btn-primary float-right" />
      </div>
    </form>

    <h5>Existing Videos</h5>
    <hr>
      <!-- Project One -->
      <?php
      foreach($json->shortFormVideos as $js) {
      ?>

      <div class="row">
        <div class="col-md-7">
          <a href="editVideo.php?id=<?=$js->id;?>&file=<?=$_GET["file"];?>">
            <img class="img-fluid rounded mb-3 mb-md-0" src="<?=$js->thumbnail;?>" alt="">
          </a>
        </div>
        <div class="col-md-5">
          <h3><?=$js->title;?></h3>
          <p>
            Genres: <?php
              foreach($js->genres as $genres) {
                echo $genres.", ";
              }?><br />
            Tags: <?php
              foreach($js->tags as $tags) {
                echo $tags.", ";
              }?><br />
            Release Date: <?=$js->releaseDate;?><br />
          <p><?=$js->shortDescription;?></p>
          <a class="btn btn-primary" href="editVideo.php?id=<?=$js->id;?>&file=<?=$_GET["file"];?>">Edit Video</a>
          <a class="btn btn-warning" href="deleteVideo.php?id=<?=$js->id;?>&file=<?=$_GET["file"];?>">Delete Video</a>
        </div>
      </div>
    <?php } ?>
      <!-- /.row -->

      <hr>

      <!-- Pagination -->
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>

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