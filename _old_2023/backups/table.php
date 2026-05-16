<?php

##
## Скрипт сервера.
## Его задача: выводить из json файла таблицу.
##
## Авторство: Дыбка Даниил Викторович
## Почта: daniil@dybka.ru
## Сайт: vr.creagoo.ru
##

function IfNull($a)
{
    if (!isset($a)) return "<i>Null</i>";
    return $a;
}

function IsON($bool)
{
    if ($bool) return "ON";
    return "OFF";
}

$jsonfile = file_get_contents("index.txt");
$array = json_decode($jsonfile);

foreach ($array as $b) {
    var_dump($b);
    echo "<br>";
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WEBVR Table</title>

    <style>
        table {
            margin: 0 auto;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 90%;
            padding: 50px;

        }

        .table tr,
        .table td {
            font-size: 1.5rem;
        }

        td,
        th {
            border: 1px solid #f4f4f4;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f6f6f6;
        }

        .empty {
            color: #949494;
        }
    </style>

</head>

<body>
    <h1>WEBVR Table</h1>

    <div id="table" class="table" style="margin: 0 auto; margin-top: 10rem; margin-bottom: 10rem;">
        <table>
            <tr>
                <th>#</th>
                <th>Element</th>
                <th>IS ON</th>
                <th>Generated Power, kWt</th>
                <th>Required Power, kWt</th>
                <th>Power, kWt</th>
            </tr>

            <?php $c = 1; ?>
            <?php foreach ($array as $item) : ?>

                <tr>
                    <td>
                        <?php echo $c ?>
                    </td>
                    <td>
                        <?php echo IfNull($item->ID) ?>
                    </td>
                    <td>
                        <?php echo IsON($item->IsON) ?>
                    </td>
                    <td>
                        <?php echo IfNull($item->GeneratedPower) ?>
                    </td>
                    <td>
                        <?php echo IfNull($item->RequiredPower) ?>
                    </td>
                    <td>
                        <?php echo IfNull($item->Power) ?>
                    </td>
                </tr>

                <?php $c += 1; ?>
            <?php endforeach; ?>

        </table>
    </div>

</body>

</html>