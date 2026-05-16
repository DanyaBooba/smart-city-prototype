<?php
function Errors($error)
{
    $list = [
        1 => "Ошибка в параметрах",
        2 => "Неправильный логин",
        3 => "Неправильный пароль",
    ];

    return empty($list[$error]) ? false : $list[$error];
}
