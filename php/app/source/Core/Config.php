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
  
  /* UPLOADS*/
  define('CONF_UPLOADS_FOLDER', __DIR__.'/../../uploads/');

  /* IMAGES */
  define('CONF_IMG_FOLDER', 'images');
  define('CONF_IMG_SLIDE_DEF_WIDTH', 1440);
  define('CONF_IMG_SLIDE_DEF_HEIGHT', 330);
  define('CONF_IMG_COVER_DEF_WIDTH', 300);
  define('CONF_IMG_COVER_DEF_HEIGHT', 145);
  define('CONF_IMG_COVER_RESOLUTIONS_WIDTH', [300]);
  define('CONF_IMG_COVER_RESOLUTIONS_HEIGHT', [145]);
  define('CONF_IMG_SLIDE_RESOLUTIONS_WIDTH', [1440, 720, 320 ]);
  define('CONF_IMG_SLIDE_RESOLUTIONS_HEIGHT', [330, 405, 180]);
  define('CONF_IMG_ALLOW_TYPES', ['image/jpg', 'image/png', 'image/jpeg', 'image/webp']);
  define('CONF_IMG_UPLOAD_FOLDER_PATH', CONF_UPLOADS_FOLDER.'images/');

