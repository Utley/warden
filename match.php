<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous" />
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <style>
    .item {
      height: 33px;
    }
  </style>
  <link rel="stylesheet" href="css/default.css" />
</head>
<body>
<?php include 'nav.php' ?>
<form action="match.php">
  <input type="text" name="match" id="matchId" />
  <input type="submit" />
</form>

<?php
$matchID = $_REQUEST['match'];
$apiKey = trim(file_get_contents('/.config/apikey'));

include 'heroesLib.php';
include 'itemsLib.php';
include 'matchLib.php';

function getMatchString( $id ){
  $text = file_get_contents("/home/stephen/public_html/warden/data/modes.json");
  $parsed = json_decode( $text );
  return $parsed->mods[intval($id)]->name;
};

function getMatchDetails( $matchID ){
  global $apiKey;

  $heroesArray = getHeroesArray();
  $itemsArray = getItemsArray();
  $match = getMatchObject( $matchID );
  $players = $match->players;
  $matchString = getMatchString($match->game_mode);
  echo "<h1>$matchID ($matchString)</h1>";
  echo "<h2>Began on " . date("l, F jS G:i:s", $match->start_time) . "</h2>";

  echo "<table class='table table-striped'>";
  echo "<tr>";
  echo "<th></th>";
  echo "<th>LH</th>";
  echo "<th>D</th>";
  echo "<th>XPM</th>";
  echo "<th>GPM</th>";
  echo "<th>HD</th>";
  echo "<th>TD</th>";
  echo "<th colspan=6>Items</th>";
  echo "</tr>";
  for($i = 0; $i < count($players); $i++){
    $player = $players[$i];
    if($i < count($players) / 2){
      echo "<tr class='success'>";
    }
    else {
      echo "<tr class='danger'>";
    }
    echo "<td>";
    if($player->hero_id > 0){
      $smallName = str_replace("npc_dota_hero_","",$heroesArray[$player->hero_id]);
      echo "<a href='player.php?player=$player->account_id'>";
      echo "<img src='http://cdn.dota2.com/apps/dota2/images/heroes/$smallName" . "_sb.png'/>";
      echo "</a>";
    }
    else{
      echo '<img src="unknown.png" />';
    }
    echo "</td>";
    echo "<td>$player->last_hits</td>";
    echo "<td>$player->denies</td>";
    echo "<td>$player->xp_per_min</td>";
    echo "<td>$player->gold_per_min</td>";
    echo "<td>$player->hero_damage</td>";
    echo "<td>$player->tower_damage</td>";

    $items = [$player->item_0, $player->item_1, $player->item_2, $player->item_3, $player->item_4, $player->item_5];
    for( $j = 0; $j < count($items); $j++ ){
      $item = $itemsArray[$items[$j]];
      $shortName = str_replace("item_","",$item);
      if(substr_count("item_",$shortName) > -1){
        echo "<td><img class='item' src='http://cdn.dota2.com/apps/dota2/images/items/" . $shortName . "_lg.png'></td>";
      }
      else{
        echo "<td><img class='item' src='unknown_item.png' /></td>";
      }
    }
    echo "</tr>";
  }

  echo "</table>";
  echo "<!--" . $response . "-->";

}
if(isset($matchID)){
  getMatchDetails($matchID);
}
else
{
  getMatchDetails(2002487825);
}
?>
</body>
</html>
