<?php
  if(isset($_POST["word"]) && isset($_POST["searchType"]) && !empty($_POST["word"])) {
  	include("include/OxfordAPI.php");
  	include("config.php");
  	if(isset($_POST["lang2"]) && in_array($_POST["lang2"],['en', 'es', 'lv', 'nso', 'zu', 'ms', 'id', 'tn', 'hi', 'ur', 'sw', 'ro'])) {
  		$lang2 = $_POST["lang2"];
  	} else {
  		$lang2 = $config["lang2"];
  	}
  	$OxfordAPI = new OxfordAPI($_POST["searchType"],$_POST["word"],$config["lang1"],$lang2);
  	$result = $OxfordAPI->get($config["app_id"],$config["app_key"]);
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Online Dictionary</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
  </head>

  <body>
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">Dictionary</h3>
        </div>
      </header>

      <main role="main" class="inner cover">
        <?php if(isset($result)) { ?>
        <div class="card text-white bg-dark mb-3">
          <div class="card-body">
            <h1 class="text-center"><?=strtoupper($_POST["word"]);?></h1>
            <p class="card text-white bg-dark mb-3 text-justify">
               <?php
               if(!isset($result["synonyms"]) && is_array($result)) {
	               foreach($result as $res) {
	                   	echo "<li>".$res."</li>";
		           }
		        } elseif(isset($result["synonyms"]) || isset($result["antonyms"])) {

		        	if(isset($result["synonyms"]))
		            	echo "<p><strong>Synonyms: ".rtrim(implode(", ",$result["synonyms"]),',')."</strong></p>";
		            if(isset($result["antonyms"]))
		            	echo "<p><strong>Antonyms: ".rtrim(implode(", ",$result["antonyms"]),",")."</strong></p>";
	            } else {
	            	echo $config[$result];
	            }
               ?>
            </p>
          </div>
        </div>
      <?php } ?>
        <div class="card text-white bg-dark mb-3 text-center">
          <div class="card-body">
            <h1>Online Dictionary</h1>
            <p class="card text-white bg-dark mb-3">
              <form name="dictionary" method="POST" action="index.php">
                <input type="text" name="word" class="form-control form-control-lg" value="" placeholder="What would you like to lookup?" /><br />
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="searchType" id="inlineRadio1" value="dictionary" checked />
                  <label class="form-check-label" for="inlineRadio1">Definition</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="searchType" id="inlineRadio2" value="thesaurus" />
                  <label class="form-check-label" for="inlineRadio2">Thesaurus</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="searchType" id="inlineRadio3" value="translate">&nbsp; 
                  <label class="form-check-label" for="inlineRadio3">Translate</label>&nbsp;
                  <select name="lang2">
                  	<?php
                  		$languages = array('en', 'es', 'lv', 'nso', 'zu', 'ms', 'id', 'tn', 'hi', 'ur', 'sw', 'ro');
                  		foreach($languages as $langs) {
                  			echo "<option value='".$langs.">".$langs."</option>";
                  		}
                  	?>
                  </select>
                </div><br />
                <input type="submit" class="btn" value="Search" />
              </form>
            </p>
          </div>
        </div>
      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Online Dictionary by <a href="https://github.com/arshem/portfolio">Brandon Wright</a>.</p>
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