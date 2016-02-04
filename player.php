<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/default.css" />
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body>
<?php
include('nav.php');
?>
<form action="match.php">
  <input type="text" name="match" id="matchId" />
  <input type="submit" />
</form>

<?php
include('openid.php');
$playerID = isset($_REQUEST['player']) ? $_REQUEST['player'] : "76561198068938718"; //32 bit or 64 bit steam id
$key = trim(file_get_contents('/keys/apikey'));
$openid = new LightOpenID('http://utley.tech/~stephen/warden/player.php');
if(!$openid->mode){
if(isset($_REQUEST['player'])){
$openid->identity = 'http://steamcommunity.com/openid/';
header('Location: ' . $openid->authUrl());
}
?>
<form action="?player" method="post">
<input type="image" src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_small.png">
</form>
<?php
}
else {
echo $openid->validate() ? 'logged in' : 'failed';
echo $openid->identity;
$playerID = str_replace('http://steamcommunity.com/openid/id/','',$openid->identity);
}
$apiKey = trim(file_get_contents('/keys/apikey'));

include 'heroesLib.php';

function getPlayerHistory($playerID){
  global $apiKey;
  $matchesArray = [];
  $getMatchesUrl = "https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/v001/?format=JSON&key=" . $apiKey . "&account_id=" . $playerID;
  $ch = curl_init($getMatchesUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
  $matchesResult = curl_exec($ch);
  curl_close($ch);
  $matchesObject = json_decode($matchesResult);
  $matchesObjectArray = $matchesObject->result->matches;
  return $matchesObjectArray;
};
echo "<h1>Player: " . $playerID . "<br>";
$matches = getPlayerHistory($playerID);
$heroObj = [];

foreach( $matches as $match ){
  $players = $match->players;
  foreach( $players as $player ){
    if( $player->account_id + 76561197960265728 == $playerID ){
      $heroObj[ $player->hero_id ] += 1;
    }
  }
  echo "<a href='match.php?match=" . "$match->match_id'>" . $match->match_id . "</a><br>";
}
$heroesArray = getHeroesArray();
foreach($heroObj as $hero => $counts){
  echo $heroesArray[$hero] . ": " . $counts;
  echo "<br>";
}

?>
</body>
</html>
