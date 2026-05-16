<?php $json = file_get_contents("index.txt") ?>
<?php $parsejson = json_decode($json, true) ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Smart city prototype — view json</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body>
    <main class="container">
        <div class="mb-5">
            <p><?php echo $json ?></p>
        </div>
        <div class="mb-5">
            <?php foreach ($parsejson as $j) : ?>
                <p><?php var_dump($j) ?></p>
            <?php endforeach; ?>
        </div>
        <div class="mb-5">
            <code>
                <pre><?php echo var_dump($parsejson) ?></pre>
            </code>
        </div>
    </main>
</body>
