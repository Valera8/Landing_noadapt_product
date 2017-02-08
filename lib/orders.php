<?php
require_once "service_class.php";
$service = Service::getObject(); /*К БД обратиться только один раз*/
if (isset($_POST['buy']))
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $aid = trim($_POST['aid']);
    /*Результат заказа в $ord_success*/
    $ord_success = $service->order($name, $email, $aid);
}
?>

<html>
<head>
    <title>Заказы</title>
</head>
<body>
    <?php
    if ($_POST['buy'])
    {
        if ($ord_success)
        {
            echo "<span  class='error'>Заказ выполнен успешно!</span>";
        }
        else
        {
            echo "<span  class='error'>Ошибка в оформлении заказа! Заполните все поля заказа корректно.</span>";
        }
    }
    ?>
    <h1>Заказы</h1>

    <form action="orders.php" method="post">
        <p>Имя:
        <input type="text" name="name" value="<?php echo $name; ?>">
        </p>
        <p>Email:
        <input type="email" name="email" value="<?php echo $email; ?>">
        </p>
        <p>Вид услуги:
        <input type="text" name="aid" value="
        <?php
        if ($_GET['title'])
        {
            echo $_GET['title'];
        }
        else
        {
            echo $aid;
        }
        ?>
        ">
        </p>
        <p>
        <input type="submit" name="buy" value="Заказать">
        </p>
    </form>
</body>
</html>