<?php
$mysql = new mysqli("localhost", "u1156718_webvr", "fghjkltyuiop_webvr2022", "u1156718_webvr");

$sql = "SELECT * FROM webvrstats";
$db = mysqli_query($mysql, $sql);
$results = mysqli_fetch_row($db);

function TextView($value) {
    if($value == "1") return "Выключить";
    return "Включить";
}

function CSSView($value){
    if($value == "1") return "btn-danger";
    return "btn-primary";
}

function TextEdit($value){
    if($value == "system"){
        return "Энергостенд";
    }
    else if($value == "substation") {
        return "Подстанция";
    }
    else if($value == "minisubstation_1") {
        return "Мини подстанция (1)";
    }
    else if($value == "minisubstation_2") {
        return "Мини подстанция (2)";
    }
    else if($value == "solarbattery_1") {
        return "Солнечная Батарея (1)";
    }
    else if($value == "solarbattery_2") {
        return "Солнечная Батарея (2)";
    }
    else if($value == "factory_1") {
        return "Завод (1)";
    }
    else if($value == "factory_2") {
        return "Завод (2)";
    }
    else if($value == "hospital_1") {
        return "Больница (1)";
    }
    else if($value == "hospital_2") {
        return "Больница (2)";
    }
    else if($value == "md_1") {
        return "Микрорайон (1)";
    }
    else if($value == "md_2") {
        return "Микрорайон (2)";
    }
    else if($value == "md_3") {
        return "Микрорайон (3)";
    }
    else if($value == "md_4") {
        return "Микрорайон (4)";
    }
    else if($value == "md_5") {
        return "Микрорайон (5)";
    }
    else if($value == "md_6") {
        return "Микрорайон (6)";
    }
    else if($value == "md_6") {
        return "Микрорайон (6)";
    }
    else{
        return $value;
    }
}

function CheckValue($value){
    if($value == "system"){
        return "Главная задача - управление системой";
    }
    else if($value == "substation") {
        return "Распределение энергии по источникам";
    }
    else if($value == "minisubstation_1" || $value == "minisubstation_2") {
        return "Помощь в распределении нагрузки";
    }
    else if($value == "solarbattery_1" || $value == "solarbattery_2") {
        return "Вырабатывает энергию за счет света солнца";
    }

    return "true";
}
?>

<link rel="stylesheet" href="/css/bootstrap.min.css">

<?php if($mysql == false): ?>

    <p><i>Нет данных</i></p>

<?php else: ?>

    <div class="container">
    <?php if($results[2] == "0"): ?>
        
        <div class="flex-wrap d-flex justify-content-between">
            <p class="fs-4 m-0">
                Энергостенд
            </p>
            <form action="/stats/form-index.php" method="post">
                <input type="text" name="build" value="system" style="display: none!important">
                <button type="submit" class="btn btn-primary">Включить</button>
            </form>
        </div>

        <p class="text-muted fs-4"><i>Для отображения зданий включите Энергостенд</i></p>
        
    <?php elseif($results[2] == "1"): ?>

        <?php foreach($db as $res): ?>
            <div class="flex-wrap d-flex justify-content-between">
                <p class="fs-4 m-0 mb-3 me-auto">
                    <?php echo TextEdit($res["namebuild"]) ?>
                </p>
                <?php if(CheckValue($res["namebuild"]) == "true"): ?>
                <div class="d-flex">
                    <form class="me-3" action="/stats/form-index-on.php" method="post">
                        <input type="text" name="build" value="<?php echo $res["namebuild"] ?>" style="display: none!important">
                        <button type="submit" class="btn btn-primary">Включить</button>
                    </form>
                    <form action="/stats/form-index-off.php" method="post">
                        <input type="text" name="build" value="<?php echo $res["namebuild"] ?>" style="display: none!important">
                        <button type="submit" class="btn btn-danger">Выключить</button>
                    </form>
                </div>
                <?php else: ?>
                    <p class="fs-6 text-muted m-0"><?php echo CheckValue($res["namebuild"]) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
    </div>

<?php endif; ?>