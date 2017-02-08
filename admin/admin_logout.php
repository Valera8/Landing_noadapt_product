<?php
session_start ();
if ($_SESSION['auth'] == false) exit('Запрещено');
unset ($_SESSION['login']);
unset ($_SESSION['password']);
unset ($_SESSION['auth']);
session_destroy ();
?>
<html>
<head>
    <title>Административная панель</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <table align="center">
        <tr>
            <td class= "loginbox1">Выход выполнен</td>
        </tr>
        <tr>
            <td class="loginbox2"><a href="index.php">Вернуться в админку</a></td>
        </tr>
    </table>
</body>
</html>