<?php
function getItemsArray(){
  global $apiKey;
  $itemsArray = [];
  $getItemsUrl = "https://api.steampowered.com/IEconDOTA2_570/GetGameItems/v0001/?key=" . $apiKey . "&language=en";
  $ch = curl_init($getItemsUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);    # required for https urls
  $heroesResult = curl_exec($ch);
  curl_close($ch);
  $itemsObject = json_decode($heroesResult);
  $itemsObjectArray = $itemsObject->result->items;
  foreach ($itemsObjectArray as $item){
    $itemsArray[$item->id] = $item->name;
  }
  return $itemsArray;
};
?>
