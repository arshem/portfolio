<?php
  if(isset($_POST["word"]) && isset($_POST["searchType"]) && !empty($_POST["word"])) {
    $apiUrl = "https://od-api.oxforddictionaries.com/api/v1/entries/en/";
    $appKey = "APP_KEY";
    $appId = "APP_ID";
    switch($_POST["searchType"]) {
      case 'dictionary':
        $apiUrl = $apiUrl.strtolower(urlencode($_POST["word"]));
      break;
/*
      case 'thesaurus':
        $apiUrl = $apiUrl.strtolower(urlencode($_POST["word"]))."/synonyms;antonyms";
      break;
      case 'translate':
        $apiUrl = $apiUrl.strtolower(urlencode($_POST["word"]))."/translations=es";
*/
    }

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $headers = [
      "Accept: application/json",
      "app_id:".$appId,
      "app_key:".$appKey
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $output = curl_exec($ch);
    curl_close($ch);
    $info = json_decode($output,true);
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

  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <h3 class="masthead-brand">Dictionary</h3>
        </div>
      </header>

      <main role="main" class="inner cover">
        <?php if(isset($info)) { ?>
        <div class="card text-white bg-dark mb-3">
          <div class="card-body">
            <h1>Results</h1>
              <?php
              foreach($info["results"] as $res) { 
                if(is_array($res["lexicalEntries"]))
                  foreach($res["lexicalEntries"] as $lex) {
                    if(is_array($lex["entries"]))
                      foreach($lex["entries"] as $ent) { 
                        if(is_array($ent["etymologies"]))
                          foreach($ent["etymologies"] as $ety) {
                            if(is_array($ent["senses"]))
                              foreach($ent["senses"] as $senses) {
                                if(is_array($senses["definitions"]))
                                  foreach($senses["definitions"] as $defs) {
              ?>
            <p class="card text-white bg-dark mb-3 text-justify">
                <?=$res["id"];?> <?=$lex["lexicalCategory"];?> <br />
                Etymology: <?=$ety;?><br />
                Definition: <?=$defs;?><br />
              <?php }}}}}} ?>
            </p>
          </div>
        </div>
      <?php } ?>
        <div class="card text-white bg-dark mb-3">
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
                  <input class="form-check-input" type="radio" name="searchType" id="inlineRadio3" value="translate">
                  <label class="form-check-label" for="inlineRadio3">Translate</label>
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