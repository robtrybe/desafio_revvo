<?php

/* Views */
define('CONF_VIEW_PATH', __DIR__.'/../../views');
define('CONF_VIEW_THEME', 'site');
define('CONF_VIEW_EXT', 'php');


/* URLS */
define('CONF_TEST_URL', 'http://localhost:8000'); # Desenvolvimento
define('CONF_BASE_URL', 'http://localhost:8000'); # Produção
define('CONF_URL_ASSETS', 'http://localhost:8000/assets/');

/**
 * MESSAGE
 */

 define('CONF_MESSAGE_CLASS', 'message');
 define('CONF_MESSAGE_SUCCESS', 'success');
 define('CONF_MESSAGE_INFO', 'info');
 define('CONF_MESSAGE_WARNING', 'warning');
 define('CONF_MESSAGE_ERROR', 'error');

 /**
  * PASSWORD
  */

  define('CONF_PASSWORD_MIN_LEN', 8);
  define('CONF_PASSWORD_MAX_LEN', 12);
  
  /* UPLOADS*/
  define('CONF_UPLOADS_FOLDER', __DIR__.'/../../uploads/');

  /* IMAGES */
  define('CONF_IMG_FOLDER', 'images');
  define('CONF_IMG_SLIDE_DEF_WIDTH', 1440);
  define('CONF_IMG_SLIDE_DEF_HEIGHT', 330);
  define('CONF_IMG_COVER_DEF_WIDTH', 320);
  define('CONF_IMG_COVER_DEF_HEIGHT', 165);
  define('CONF_IMG_COVER_RESOLUTIONS_WIDTH', [320]);
  define('CONF_IMG_COVER_RESOLUTIONS_HEIGHT', [165]);
  define('CONF_IMG_SLIDE_RESOLUTIONS_WIDTH', [1440, 720, 320 ]);
  define('CONF_IMG_SLIDE_RESOLUTIONS_HEIGHT', [330, 165, 73]);
  define('CONF_IMG_ALLOW_TYPES', ['image/jpg', 'image/png', 'image/jpeg', 'image/webp']);
  define('CONF_IMG_UPLOAD_FOLDER_PATH', CONF_UPLOADS_FOLDER.'images/');

  /* DATABASE */
  define('DATA_LAYER_CONFIG', [
    "driver" => $_ENV['MYSQL_DRIVER'],
    "host" => $_ENV['MYSQL_HOST'],
    "port" => $_ENV['MYSQL_PORT'],
    "dbname" => $_ENV['MYSQL_DBNAME'],
    "username" => $_ENV['MYSQL_USER'],
    "passwd" => $_ENV['MYSQL_PASSWORD'],
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
  ]);

  define('CONF_MYSQL_HOST', $_ENV['MYSQL_HOST']);
  define('CONF_MYSQL_DB_NAME', $_ENV['MYSQL_DBNAME']);
  define('CONF_MYSQL_DRIVER', $_ENV['MYSQL_DRIVER']);
  define('CONF_MYSQL_USER', $_ENV['MYSQL_USER']);
  define('CONF_MYSQL_PASSWORD', $_ENV['MYSQL_PASSWORD']);
  define('CONF_MYSQL_PORT', $_ENV['MYSQL_PORT']);


