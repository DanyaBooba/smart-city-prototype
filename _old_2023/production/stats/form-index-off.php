<?php
$build = $_POST["build"];

if(empty($build)) {
    echo "empty";
    exit;
}

$mysql = new mysqli("localhost", "u1156718_webvr", "fghjkltyuiop_webvr2022", "u1156718_webvr");

if($mysql == false){
    echo "database 404";
    exit;
}

$sql = "SELECT statebuild FROM webvrstats WHERE namebuild like '$build'";
$db = mysqli_query($mysql, $sql);
$result = mysqli_fetch_row($db)[0];

$value = 0;
$sql2 = "UPDATE webvrstats SET statebuild=$value WHERE namebuild like '$build'";
$db2 = mysqli_query($mysql, $sql2);

if($db2 == false) {
   echo "result 404";
    exit; 
}

header("Location: /stats");