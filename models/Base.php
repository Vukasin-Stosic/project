<?php

class Base
{
    protected $sql;
    const HOST = "localhost";
    const DB_USER = "root";
    const DB_PASSWORD = "";
    const DB_NAME = "ordinacija";

    public function __construct()
    {
        $this->sql = mysqli_connect(self::HOST, self::DB_USER, self::DB_PASSWORD, self::DB_NAME);
    }
}
