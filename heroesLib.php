<?php
function getHeroesArray(){
  global $apiKey;
  $heroesArray = [];
  $getHeroesUrl = "https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/?key=" . $apiKey;
  $heroesResult = file_get_contents( "/home/stephen/public_html/warden/data/heroes.json" );
  fclose($herofile);
  $heroesObject = json_decode($heroesResult);
  $heroesObjectArray = $heroesObject->result->heroes;
  foreach ($heroesObjectArray as $hero){
    $heroesArray[$hero->id] = $hero->name;
  }
  return $heroesArray;
};
function updateHeroes(){
  global $apiKey;
  $heroesArray = [];
  $getHeroesUrl = "https://api.steampowered.com/IEconDOTA2_570/GetHeroes/v0001/?key=" . $apiKey;
  $ch = curl_init($getHeroesUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
  $heroesResult = curl_exec($ch);
  curl_close($ch);
  $herofile = fopen("/home/stephen/public_html/warden/data/heroes.json", "w");
  fwrite($herofile, $heroesResult);
  fclose($herofile);
};
/*
function getHeroesArray(){
  getLatestHeroesArray();
  $herofile = fopen("/home/stephen/public_html/warden/heroes.json", "r");
  $text = fread($herofile,filesize("/home/stephen/public_html/warden/heroes.json"));
  $heroesObject = $json_decode($text);
  $heroesObjectArray = $heroesObject->result->heroes;
  foreach ($heroesObjectArray as $hero){
    $heroesArray[$hero->id] = $hero->name;
  }
  return $heroesArray;
}
*/
?>
