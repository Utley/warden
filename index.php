<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="css/default.css" />
</head>
<body>
  <?php include 'nav.php' ?>
  <h1>Latest matches:</h1>

<?php
$heroesArray = [];
$apiKey = trim(file_get_contents('/keys/apikey'));

include 'heroesLib.php';

$heroesArray = getHeroesArray();
$numberMatches = 5;
$steamUrl = "https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?format=JSON&matches_requested=" . $numberMatches . "&key=" . $apiKey;
$ch = curl_init($steamUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
$head = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$obj = json_decode($head);
$latestMatches = $obj->result->matches;
echo '<br>';
for($i = 0; $i < sizeof($latestMatches); $i++){
  echo "<a class='matchLink' href='match.php?match=" . $latestMatches[$i]->match_id . "'>Match: " . $latestMatches[$i]->match_id . "</a>";
  $mID = $latestMatches[$i]->match_id;

  echo '<br>';
  foreach ($latestMatches[$i]->players as $player){
    $smallName;
    if($player->hero_id > 0){
      $smallName = str_replace("npc_dota_hero_","",$heroesArray[$player->hero_id]);
      echo '<img src="' . 'http://cdn.dota2.com/apps/dota2/images/heroes/' . $smallName . '_sb.png" title="' . $smallName . '"/>';
    }
    else{
      echo '<img src="unknown.png" />';
    }

    echo '<br>';
  }
  echo '<br>';
}
echo '<br>';
?>
</body>
</html>
