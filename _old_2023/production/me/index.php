<?php include_once "php/m/check-login.php" ?>
<?php
$login = CheckLogin($_COOKIE['email'], $_COOKIE['uniquecode']);
if ($login == false) {
    unset($_COOKIE['email']);
    unset($_COOKIE['uniquecode']);
    setcookie('email', null, -1, '/');
    setcookie('uniquecode', null, -1, '/');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "php/c/head.php" ?>
    <style>
        .access {
            margin-bottom: -4px;
        }

        .main--block {
            transition: .3s;
        }

        .main--block:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
</head>

<body>
    <?php include_once "php/c/header.php" ?>

    <main class="container">
        <div class="row row-cols-2 row-cols-lg-3 mb-3">
            <div class="col">
                <div class="px-2">
                    <div class="bg-light main--block border border-2" style="border-radius: 12px;">
                        <div class="p-3">
                            <div class="d-flex flex-wrap align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="dark" class="pe-3" viewBox="0 0 16 16">
                                    <path d="M13.879 10.414a2.501 2.501 0 0 0-3.465 3.465l3.465-3.465Zm.707.707-3.465 3.465a2.501 2.501 0 0 0 3.465-3.465Zm-4.56-1.096a3.5 3.5 0 1 1 4.949 4.95 3.5 3.5 0 0 1-4.95-4.95ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z" />
                                </svg>
                                <div class="d-flex flex-wrap flex-column">
                                    <span class="text-muted access" style="letter-spacing: 1px; font-size: 13px">ДОСТУП</span>
                                    <p class="h3 mb-0">Без регистрации</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="px-2">
                    <div class="bg-light main--block border border-2" style="border-radius: 12px;">
                        <div class="p-3">
                            <div class="d-flex flex-wrap align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="dark" class="pe-3" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                </svg>
                                <div class="d-flex flex-wrap flex-column">
                                    <span class="text-muted access" style="letter-spacing: 1px; font-size: 13px">ДОСТУП</span>
                                    <p class="h3 mb-0">Максимальный</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="px-2">
                    <div class="bg-light main--block border border-2" style="border-radius: 12px;">
                        <div class="p-3">
                            <div class="d-flex flex-wrap align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="dark" class="pe-3" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="m4.736 1.968-.892 3.269-.014.058C2.113 5.568 1 6.006 1 6.5 1 7.328 4.134 8 8 8s7-.672 7-1.5c0-.494-1.113-.932-2.83-1.205a1.032 1.032 0 0 0-.014-.058l-.892-3.27c-.146-.533-.698-.849-1.239-.734C9.411 1.363 8.62 1.5 8 1.5c-.62 0-1.411-.136-2.025-.267-.541-.115-1.093.2-1.239.735Zm.015 3.867a.25.25 0 0 1 .274-.224c.9.092 1.91.143 2.975.143a29.58 29.58 0 0 0 2.975-.143.25.25 0 0 1 .05.498c-.918.093-1.944.145-3.025.145s-2.107-.052-3.025-.145a.25.25 0 0 1-.224-.274ZM3.5 10h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Zm-1.5.5c0-.175.03-.344.085-.5H2a.5.5 0 0 1 0-1h3.5a1.5 1.5 0 0 1 1.488 1.312 3.5 3.5 0 0 1 2.024 0A1.5 1.5 0 0 1 10.5 9H14a.5.5 0 0 1 0 1h-.085c.055.156.085.325.085.5v1a2.5 2.5 0 0 1-5 0v-.14l-.21-.07a2.5 2.5 0 0 0-1.58 0l-.21.07v.14a2.5 2.5 0 0 1-5 0v-1Zm8.5-.5h2a.5.5 0 0 1 .5.5v1a1.5 1.5 0 0 1-3 0v-1a.5.5 0 0 1 .5-.5Z" />
                                </svg>
                                <div class="d-flex flex-wrap flex-column">
                                    <span class="text-muted access" style="letter-spacing: 1px; font-size: 13px">ДОСТУП</span>
                                    <p class="h3 mb-0">Администратор</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-lg-3">
            <div class="col">
                <div class="px-2">
                    <p class="mb-1 h1">Возможности</p>
                    <ul>
                        <li>Просматривать содержимое прототипа умного города</li>
                        <li>Получать информацию о состояниях потребителей</li>
                        <li>Динамически обновлять контент.</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="px-2">
                    <p class="mb-1 h1">Возможности</p>
                    <ul>
                        <li>Просматривать содержимое прототипа умного города</li>
                        <li>Получать информацию о состояниях потребителей</li>
                        <li>Динамически обновлять контент</li>
                        <li>Создавать запросы на динамическое измение системы</li>
                        <li>Доступ к некоторым функциям администратора.</li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="px-2">
                    <p class="mb-1 h1">Возможности</p>
                    <ul>
                        <li>Просматривать содержимое прототипа умного города</li>
                        <li>Получать информацию о состояниях потребителей</li>
                        <li>Динамически обновлять контент</li>
                        <li>Создавать запросы на динамическое измение системы</li>
                        <li>Полностью менять функционал системы</li>
                        <li>Добавлять новые возможности.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-lg-3 mb-3">
            <div class="col">
                <div class="px-2">
                    <div class="bg-light text-center" style="border-radius: 8px">
                        <div class="p-3">Доступ по умолчанию</div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="px-2">
                    <div class="bg-light text-center" style="border-radius: 8px">
                        <div class="p-3">
                            <?php if (empty($_COOKIE['email']) || empty($_COOKIE['uniquecode'])) : ?>
                                <a href="/me/reg.php" class="link">
                                    Зарегистрироваться
                                </a>
                            <?php else : ?>
                                <div>Зарегистрирован</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="px-2">
                    <div class="bg-light text-center" style="border-radius: 8px">
                        <div class="p-3">Доступ только администраторам</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once "php/c/footer.php" ?>
</body>

</html>
