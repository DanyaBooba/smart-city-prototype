<?php
function GetState($bool)
{
    if ($bool) return "<span class='text-success'>Вкл.</span>";
    return "<span class='text-danger'>Выкл.</span>";
}

function RussianBuilds($name)
{
    $list = [
        "Substation" => "Подстанция",
        "Solar Battery 1" => "Солнечная батарея №1",
        "Solar Battery 2" => "Солнечная батарея №2",
        "Mini Substation 1" => "Мини подстанция №1",
        "Mini Substation 2" => "Мини подстанция №2",
        "Hospital 1" => "Больница №1",
        "Hospital 2" => "Больница №2",
        "Factory 1" => "Завод №1",
        "Factory 2" => "Завод №2",
        "Microdistrict 1" => "Микрорайон №1",
        "Microdistrict 2" => "Микрорайон №2",
        "Microdistrict 3" => "Микрорайон №3",
        "Microdistrict 4" => "Микрорайон №4",
        "Microdistrict 5" => "Микрорайон №5",
        "Microdistrict 6" => "Микрорайон №6",
        "Wind Generator" => "Ветрогенератор",
    ];

    return $list[$name];
}

function CheckPower($power)
{
    if ($power > 100) return $power;
    return $power . "/100";
}

$jsonfile = file_get_contents("index.txt");
$array = json_decode($jsonfile);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Прототип умного города — таблица</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body class="container">
    <h1 class="mb-3">Прототип умного города — таблица</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Здание</th>
                <th scope="col">Состояние</th>
                <th scope="col">Выдаваемая мощность, кВ</th>
                <th scope="col">Требуемая мощность, кВ</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php foreach ($array as $item) : ?>
                <tr>
                    <th scope="row"><?php echo $count ?></th>
                    <td><?php echo RussianBuilds($item->ID) ?></td>
                    <td><?php echo GetState($item->IsON) ?></td>
                    <td><?php echo CheckPower($item->GeneratedPower) ?></td>
                    <td><?php echo CheckPower($item->RequiredPower) ?></td>
                </tr>
                <?php $count += 1; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="bg-light py-3">
        <div class="container">
            <a href="/json/table-en.php">Таблица на английском</a>
        </div>
    </div>

</body>

</html>
