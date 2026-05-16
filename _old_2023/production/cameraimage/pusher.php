<?php

$data = (int) file_get_contents('../img/camera/ver.txt');
$data += 1;

$data = strval($data);

var_dump($data);

file_put_contents('../img/camera/ver.txt', $data, LOCK_EX);
