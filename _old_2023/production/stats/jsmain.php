<?php
include_once "../php/rb-mysql.php";

// $mysql = new mysqli("localhost", "u1156718_webvr", "fghjkltyuiop_webvr2022", "u1156718_webvr");
R::setup('mysql:host=localhost;dbname=u1156718_webvr', 'u1156718_webvr', 'fghjkltyuiop_webvr2022');
$key = $_GET["k"];

$findbykey = R::getAll("SELECT * FROM webvrstats WHERE (namebuild like '$key')");

if (count($findbykey) == 1) {
    $status = $findbykey[0]["statebuild"];
    $newstat = 0;
    if ($status == 0) {
        $newstat = 1;
    }
    R::getAll("UPDATE webvrstats SET statebuild=$newstat WHERE (namebuild like '$key')");
} else {
    var_dump("STOP");
}
