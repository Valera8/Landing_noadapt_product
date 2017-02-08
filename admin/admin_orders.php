<?php
require_once "admin_class.php";
/* Создадим объект */
$admin = Admin::getObject();//Создаём объект базы данных
session_start ();
if ($_SESSION['auth'] == false) exit('Запрещено');
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Заказы</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<table align="center">
    <tr>
        <td class=loginbox1>Административная панель</td>
        <td class=loginbox2><a href="main.php">Перейти к услугам</a></td>
        <td class=loginbox2><a href="admin_logout.php">Выход</a></td>
    </tr>
</table>
<h1>Заказы</h1>
<table class="table" border="1" align="center">
    <tr class="loginbox1">
        <th>Заказчик</th>
        <th>Email</th>
        <th>Услуга</th>
        <th>Дата заказа</th>
    </tr>
    <?php
    $query = "SELECT `name`, `e-mail`, `aid`, `orderdate` FROM `orders` WHERE `id` > {?}";
/* Вместо {?} подставится 0 из array в следующей строке */
/* Применим метод select, т.к. возвратится таблица результатов */
    $table = $admin->select($query, array(0));
    ?>
            <tr class="loginbox2">
                <?php
                for ($i = 0; $i < count($table); $i++)
                {
                    echo "<td>" . ($table["$i"]['name']) . "</td>"  . "<td>" . ($table["$i"]['e-mail']) . "</td>" . "<td>" . ($table["$i"]['aid']) . "<td>" . (date("d.m.y G:i", $table["$i"]['orderdate'])) . "</td>" .
            "</tr>";
                }
                ?>
</table>
</body>
</html>