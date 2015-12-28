<html>
<head>
</head>
<body>
  <h1>Latest matches:</h1>

<?php
$heroesArray = [];
$apiKey = trim(file_get_contents(__DIR__ . '/apikey'));
//$apiKey = "9AAC511CA9F6E38435866DD57DDDACA2";
function getHeroesArray(){
  global $apiKey;
  $heroesArray = [];
  $getHeroesUrl = "https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/?key=" . $apiKey;
  $ch = curl_init($getHeroesUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
  $heroesResult = curl_exec($ch);
  curl_close($ch);
  $heroesObject = json_decode($heroesResult);
  $heroesObjectArray = $heroesObject->result->heroes;
  foreach ($heroesObjectArray as $hero){
    $heroesArray[$hero->id] = $hero->name;
  }
  return $heroesArray;
};
$heroesArray = getHeroesArray();
$steamUrl = "https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?format=JSON&matches_requested=2&key=" . $apiKey;
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
  echo "<a href='match.php?match=" . $latestMatches[$i]->match_id . "'>Match: " . $latestMatches[$i]->match_id . "</a>";
  $mID = $latestMatches[$i]->match_id;

  echo '<br>';
  foreach ($latestMatches[$i]->players as $player){
    $smallName = str_replace("npc_dota_hero_","",$heroesArray[$player->hero_id]);

    echo "Hero: " . $smallName;
    echo '<img src="' . 'http://cdn.dota2.com/apps/dota2/images/heroes/' . $smallName . '_sb.png"/>';
    echo '<br>';
  }
  echo '<br>';
}
echo '<br>';
?>
</body>
</html>
