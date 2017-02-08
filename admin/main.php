<?php
require_once "admin_class.php";
/* Создадим объект */
$admin = Admin::getObject();
/* Проверяем авторизован ли */
session_start ();
if ($_SESSION['auth'] == true)
{
    $auth = true;
}
else
{
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['password'];
    $auth = $admin->isAuth();
    $_SESSION['auth'] = $auth;
}
if ($auth == false) exit('Запрещено');
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <table cellpadding=0 cellspacing= «0»>
        <tr>
            <td class=loginbox1>Административная панель</td>
            <td class=loginbox2><a href="admin_orders.php">Перейти к заказам</a></td>
            <td class=loginbox2><a href="admin_logout.php">Выход</a></td>
        </tr>
    </table>
    <h1>Услуги</h1>
    <table class="table">
        <tr class="loginbox1">
            <th>Услуга</th>
            <th></th>
            <th></th>
        </tr>
        <!-- Лучше применить те же методы, что и на странице admin_orders.php -->
        <?php foreach($articles as $a): ?>
            <tr>
                <td><?=$a['date']?></td>
                <td><?=$a['title']?></td>
                <td>
                    <a href="index.php?action=edit&id=<?=$a['id']?>">Редактировать</a>
                </td>
                <td>
                    <a href="index.php?action=delete&id=<?=$a['id']?>">Удалить</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</body>
</html>
