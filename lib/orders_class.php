<?php
class Orders {
    private $db;
    private static $service = null;  /* шаблон Singleton для создания только одного объекта User */
    private function __construct()
    {
        $this->db = new mysqli("127.0.0.1", "root", "", "police");
        $this->db->query("SET NAMES 'utf8");
    }



    public function __destruct()
    {
        if ($this->db) $this->db->close();
    }
}
