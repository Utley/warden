<?php
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
?>
