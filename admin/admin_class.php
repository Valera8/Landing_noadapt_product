<?php
class Admin {
    private $db; /* Идентификатор соединения (https://myrusakov.ru/php-db-class.html) */
    private $sym_query = "{?}"; /* "Символ значения в запросе" для базы данных  */
    private static $admin = null; /* шаблон Singleton для создания только одного объекта Admin */
    private $adminlogin = 'Администратор';
    private $adminpassw = '12345';
    private  function __construct()
    {
        $this->db = new mysqli("127.0.0.1", "root", "", "police");
        $this->db->query("SET lc_time_names = 'ru_RU'");
        $this->db->query("SET NAMES 'utf8'");
    }
/* Проверяем существует ли уже подключение админа к базе (шаблон Singleton). Конструктор вызовется гарантировано 1 раз  Получение экземпляра класса. Если он уже существует, то возвращается, если его не было, то создаётся и возвращается (паттерн Singleton) */
    public static function getObject()
    {
        if (self::$admin ===null)
        {
            self::$admin = new Admin();
        }
        return self::$admin;
    }
/* Проверка правильности ввода логина, пароля */
    private function checkAdmin($login, $password)
    {
        if ($login == $this->adminlogin and $password == $this->adminpassw)
        {
            return true;
        }
        else return false;
    }
/* Проверка на авторизацию на main странице */
    public function isAuth()
    {
        session_start();
        $login = $_SESSION["login"];
        $password = $_SESSION["password"];
    /* Возвращаем результат выполнения функции проверки нахождения в сессии */
        return $this->checkAdmin($login, $password);
    }
/* Вспомогательный метод, который заменяет "символ значения в запросе" на конкретное значение, которое проходит через "функции безопасности". База данных */
    private function getQuery($query, $params)
    {
        if ($params) {
            for ($i = 0; $i < count($params); $i++) {
                $pos = strpos($query, $this->sym_query);
                $arg = "'".$this->db->real_escape_string($params[$i])."'";
                $query = substr_replace($query, $arg, $pos, strlen($this->sym_query));
            }
        }
        return $query;
    }
/* SELECT-метод, возвращающий таблицу результатов */
    public function select($query, $params = false)
    {
        $result_set = $this->db->query($this->getQuery($query, $params));
        if (!$result_set) return false;
        return $this->resultSetToArray($result_set);
    }
/* SELECT-метод, возвращающий значение из конкретной ячейки */
    public function selectCell($query, $params = false) {
        $result_set = $this->db->query($this->getQuery($query, $params));
        if ((!$result_set) || ($result_set->num_rows != 1)) return false;
        else {
            $arr = array_values($result_set->fetch_assoc());
            return $arr[0];
        }
    }
/* Преобразование result_set в двумерный массив */
    private function resultSetToArray($result_set) {
        $array = array();
        while (($row = $result_set->fetch_assoc()) != false) {
            $array[] = $row;
        }
        $result_set->close();/* Закрываем, иначе таблица не освободится от потока. Будет занят ресурс сервера */
        return $array;
    }
/* Закрытие соединения с базой данных */
    public function __destruct()
    {
        if ($this->db) $this->db->close();
    }
}