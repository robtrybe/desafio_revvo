<?php

namespace Source\Core;

use PDO;
use PDOException;
use Source\Exceptions\DefaultException;

class DBConnect {
    private static $instance;

    final function __construct(){}

    final function __clone(){}

    public static function getInstance() {
        if(empty(self::$instance)){
            try{
                self::$instance = new PDO(CONF_MYSQL_DRIVER.':dbname='.CONF_MYSQL_DB_NAME.';'.'host='.CONF_MYSQL_HOST,
                CONF_MYSQL_USER, CONF_MYSQL_PASSWORD);
            }catch(DefaultException $e) {
                throw new DefaultException('Não possível se conectar ao banco!', 500);
            }
        }

        return self::$instance;
    }

}