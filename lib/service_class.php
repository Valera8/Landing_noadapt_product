<?php
class Service {
    private $db;
    private $ok = 1;
    private static $service = null;  /* шаблон Singleton для создания только одного объекта Service */
    private function __construct()
    {
        $this->db = new mysqli("127.0.0.1", "root", "", "police");
        $this->db->query("SET NAMES 'utf8");
    }
/* Проверяем существует ли уже подключение пользователя к базе (шаблон Singleton). Конструктор вызовется гарантировано 1 раз */
    public static function getObject()
    {
        if (self::$service ===null)
        {
            self::$service = new Service();
        }
        return self::$service;
    }
/*Добавление заказа*/
    public function order($name, $email, $aid)
    {
        setcookie("name", $name, time() + 600);
        setcookie("email", $email, time() + 600);
        setcookie("aid", $aid, time() + 600);
        if ($name == "") return false;
        if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $name))
        {
            echo "<p class='error'>
			Недопустимое имя. Запрещается использовать в своем имени любые символы, кроме букв русского и латинского алфавита, знака '_' (подчерк), пробела и цифр. Вернитесь, пожалуйста, обратно на поле Имени и повторите попытку
			</p>";
            $this->ok = 0;
        }
        if (!preg_match("/.{3,32}/", $name))
        {
            echo "<p class='error'>Слишком короткое или длинное имя (должно быть от 3 до 33 символов).</p>";
            $this->ok = 0;
        }

        if ($email == "") return false;
        if (!preg_match("/^[a-z0-9][a-z0-9\.-_]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i", $email))
        {
            echo "<p class='error'>Некорректный email</p>";
            $this->ok = 0;
        }
        if ($aid == "") return false;
        if (!preg_match("/(\AЮзабилите сайта интернет-магазина\z|\A2\z|\A3\z|\A4\z)/", $aid))
        {
            echo "<p class='error'>Неуспешно! Выберите вид услуги снова.</p>";
            $this->ok = 0;
        }
        if ($this->ok == 0)
        {
            return false;
        }
        return $this->db->query("INSERT INTO `orders` (`name`, `e-mail`, `aid`, `orderdate`) VALUES ('$name', '$email', '$aid', '" . time() . "')");
    }


    public function __destruct()
    {
        if ($this->db) $this->db->close();
    }
}
