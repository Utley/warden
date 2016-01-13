<?php
function getPlayersArray( $matchID ){
  global $apiKey;
  $detailsURL = "https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/V001/?match_id=$matchID&key=$apiKey";
  $ch = curl_init($detailsURL);

  $optArray = array(
    CURLOPT_RETURNTRANSFER => true
  );

  curl_setopt_array($ch, $optArray);

  $response = curl_exec($ch);
  $matchObject = json_decode($response);
  $players = $matchObject->result->players;
  return $players;
}
function getMatchObject( $matchID ){
  global $apiKey;
  $detailsURL = "https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/V001/?match_id=$matchID&key=$apiKey";
  $ch = curl_init($detailsURL);

  $optArray = array(
    CURLOPT_RETURNTRANSFER => true
  );

  curl_setopt_array($ch, $optArray);

  $response = curl_exec($ch);
  $matchObject = json_decode($response);
  return $matchObject->result;
}
?>
