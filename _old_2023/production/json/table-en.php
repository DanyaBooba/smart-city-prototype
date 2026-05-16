<?php
function GetState($bool)
{
    if ($bool) return "<span class='text-success'>Active</span>";
    return "<span class='text-danger'>Disable</span>";
}

function Builds($name)
{
    $list = [
        "Substation" => "Substation",
        "Solar Battery 1" => "Solar Battery №1",
        "Solar Battery 2" => "Solar Battery №2",
        "Mini Substation 1" => "Mini Substation №1",
        "Mini Substation 2" => "Mini Substation №2",
        "Hospital 1" => "Hospital №1",
        "Hospital 2" => "Hospital №2",
        "Factory 1" => "Factory №1",
        "Factory 2" => "Factory №2",
        "Microdistrict 1" => "Microdistrict №1",
        "Microdistrict 2" => "Microdistrict №2",
        "Microdistrict 3" => "Microdistrict №3",
        "Microdistrict 4" => "Microdistrict №4",
        "Microdistrict 5" => "Microdistrict №5",
        "Microdistrict 6" => "Microdistrict №6",
        "Wind Generator" => "Wind Generator",
    ];

    return $list[$name];
}

function CheckPower($power)
{
    if ($power >= 100) return $power;
    return $power . "/100";
}

$jsonfile = file_get_contents("index.txt");
$array = json_decode($jsonfile);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smart city prototype — table</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body class="container">
    <h1 class="mb-3">Smart city prototype — table</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Build name</th>
                <th scope="col">State</th>
                <th scope="col">Generated Power, kWt</th>
                <th scope="col">Required Power, kWt</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 1; ?>
            <?php foreach ($array as $item) : ?>
                <tr>
                    <th scope="row"><?php echo $count ?></th>
                    <td><?php echo $item->ID ?></td>
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
            <a href="/json/table.php">Table at russian</a>
        </div>
    </div>

</body>

</html>
