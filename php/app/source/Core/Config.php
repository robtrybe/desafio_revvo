<?php

/* Views */
define('CONF_VIEW_PATH', 'views');
define('CONF_VIEW_THEME', 'site');
define('CONF_VIEW_EXT', 'php');


/* URLS */
define('CONF_TEST_URL', 'http://localhost:8000'); # Desenvolvimento
define('CONF_BASE_URL', 'http://localhost:8000'); # Produção


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

  /* IMAGES */

  define('CONF_IMG_COVER_RESOLUTIONS_WIDTH', [1920, 720, 320 ]);
  define('CONF_IMG_COVER_RESOLUTIONS_HEIGHT', [1080, 405, 180]);
  define('CONF_IMG_ALLOW_TYPES', ['image/jpg', 'image/png', 'image/jpeg', 'image/webp']);