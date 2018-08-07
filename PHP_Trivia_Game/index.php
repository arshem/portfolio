<?php
/****

Created this no database online script just for fun. It's not meant to be secure, and it's not meant to be used in a live environment. Obviously if this were to be connected to an actual Database, this could be used, but as is, this was a fun project to make a "Cat Facts" quiz for my daughter. 

****/
//Load the "Database"
$flatdb = json_decode(file_get_contents("flatdb.json"),true);

//Check what question we're on
if(!isset($_REQUEST["q"])) {
  $q = 0;
} else {
  $q = $_REQUEST["q"];
}

if(!isset($_REQUEST["score"])) {
  $score = 0;
} else {
  $score = $_REQUEST["score"];
}

//If an answer is selected...
if(isset($_POST["answer"])) {
  if(strpos($_POST["answer"],"*") !== FALSE) {
    if($q+1 != count($flatdb)) {
      $q++;
    } else {
      $q = 0;
      $finished = 1;
    }
    $score++;
  } else {
    if($q+1 != count($flatdb)) {
      $q++;
    } else {
      $q = 0;
      $finished = 1;
    }
  }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Online Quiz - Porfolio Edition</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
  </head>

  <body class="text-center">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">Online Quiz</h3>
       </div>
      </header>
      <?php if($finished == 0) : ?>
      <main role="main" class="inner cover">
        <div class="card text-white bg-dark mb-3">
          <div class="card-header">
            Question <?=$q+1;?> of <?=count($flatdb);?>
          </div>
          <div class="card-body">
            <h5 class="card-title"><?=$flatdb[$q][0];?></h5>
            <?php
             $answers = explode(":",$flatdb[$q][1]);
             shuffle($answers);
            ?>
            <p class="card text-white bg-dark mb-3">
              <form name="answerForm" method="POST" action="index.php">
                <input type="hidden" name="q" value="<?=$q;?>" />
                <input type="hidden" name="score" value="<?=$score;?>" />
                <div class="card" style="color:#000;text-align:left;">
                  <ul class="list-group list-group-flush">
                <?php
                foreach($answers as $rand) {
                ?>
                <li class="list-group-item">
                  <input type="radio" name="answer" id="<?=$rand;?>" class="form-check-input" value="<?=$rand;?>" />
                  <label for="<?=$rand;?>" class="form-check-label"><?=str_replace("*","",$rand);?></label>
                </li>
                <?php } ?>
                  </ul>
                  <input type="submit" class="btn btn-primary" value="Submit" />
                </div>
              </form>
            </p>
          </div>
          <div class="card-footer">
            <h5 class="card-title">Score: <?=$score;?></h5>
          </div>
        </div>
      </main>
    <?php endif; ?>

    <?php if($finished==1): ?>
      <main role="main" class="inner cover">
        <div class="card text-white bg-dark mb-3">
          <div class="card-header">
            <h5 class="card-title">You're Done!</h5>
          </div>
          <div class="card-body">
            <?php 
            $percentage = number_format(($score/count($flatdb))*100,2);
            ?>
            <h5 class="card-title">Congrats! You've scored <?=$percentage;?>%!</h5>
            <p class="card text-white bg-dark mb-3">
              <?php
              if($percentage == 100) {
              ?>
              WOW! You're a master at this! You definitely know your cats. 
            <?php } elseif($percentage >= 80) { ?>
              GREAT JOB! You're an expert! You should be a certified cat whisperer!
            <?php } elseif($percentage >= 0) { ?>
              Not Too Bad! You sure do love cats, study hard and try again!
            <?php } ?>
              <center><a href="index.php" title="Restart Test" class="btn btn-primary">Restart Test</a></center>
            </p>
          </div>
          <div class="card-footer">
            <h5 class="card-title">Score: <?=$score;?></h5>
          </div>
        </div>
      </main>
    <?php endif; ?>
      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Simple Online Quiz for <a href="https://github.com/arshem/portfolio/">Brandon Wright Portfolio</a>, by <a href="https://www.arshem.com">Arshem Web Solutions</a>.</p>
        </div>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
