<?php

$data = strval($_GET['q']);

file_put_contents('../img/camera/ver.txt', $data, LOCK_EX);
