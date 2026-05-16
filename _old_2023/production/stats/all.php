<?php
$mysql = new mysqli("localhost", "u1156718_webvr", "fghjkltyuiop_webvr2022", "u1156718_webvr");

if($mysql == false){
    echo "database 404";
    exit;
}

$sql = "SELECT namebuild, statebuild FROM webvrstats";
$db = mysqli_query($mysql, $sql);
$rows = mysqli_fetch_all($db, MYSQLI_ASSOC);

if(!isset($rows)) {
    echo "result 404";
    exit;
}

var_dump($rows);

?>