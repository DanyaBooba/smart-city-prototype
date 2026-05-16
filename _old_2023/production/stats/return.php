<?php
$name = $_GET["b"];

if(empty($name)) {
    echo "404";
    exit;
}

$mysql = new mysqli("localhost", "u1156718_webvr", "fghjkltyuiop_webvr2022", "u1156718_webvr");
if($mysql == false){
    echo "database 404";
    exit;
}

$sql = "SELECT statebuild FROM webvrstats WHERE namebuild like '$name'";
$db = mysqli_query($mysql, $sql);

$result = mysqli_fetch_row($db)[0];

if(!isset($result)) {
    echo "result 404";
    exit;
}

echo $result;

?>