<?php
include('openid.php');
$key = trim(file_get_contents('/.config/apikey'));
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
}

?>
