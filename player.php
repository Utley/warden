<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/default.css" />
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body>
<form action="match.php">
  <input type="text" name="match" id="matchId" />
  <input type="submit" />
</form>

<?php
$playerID = isset($_REQUEST['player']) ? $_REQUEST['player'] : 108672990;
$apiKey = trim(file_get_contents('/keys/apikey'));

include 'heroesLib.php';

function getPlayerHistory($playerID){
  global $apiKey;
  $matchesArray = [];
  $getHeroesUrl = "https://api.steampowered.com/IEconDOTA2_570/GetMatchHistory/v001/?format=JSON&key=" . $apiKey . "&account_id=" . $playerID;
  $ch = curl_init($getHeroesUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
  $matchesResult = curl_exec($ch);
  echo $matchesResult;
  curl_close($ch);
  $matchesObject = json_decode($matchesResult);
  $matchesObjectArray = $matchesObject->result->matches;

};
getPlayerHistory($playerID);
?>
</body>
</html>
