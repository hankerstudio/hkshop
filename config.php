<?php
// HTTP
define('HTTP_SERVER', 'http://hkshop.sturgeon.mopaas.com/');
define('HTTP_IMAGE', 'http://hkshop.sturgeon.mopaas.com/image/');
define('HTTP_ADMIN', 'http://hkshop.sturgeon.mopaas.com/admin/');

// HTTPS
define('HTTPS_SERVER', 'http://hkshop.sturgeon.mopaas.com/');
define('HTTPS_IMAGE', 'http://hkshop.sturgeon.mopaas.com/image/');

//DIR_ROOT
$dir_root = dirname(__FILE__);

// DIR
define('DIR_APPLICATION', $dir_root.'/catalog/');
define('DIR_SYSTEM', $dir_root.'/system/');
define('DIR_DATABASE', $dir_root.'/system/database/');
define('DIR_LANGUAGE', $dir_root.'/catalog/language/');
define('DIR_TEMPLATE', $dir_root.'/catalog/view/theme/');
define('DIR_CONFIG', $dir_root.'/system/config/');
define('DIR_IMAGE', $dir_root.'/image/');
define('DIR_CACHE', $dir_root.'/system/cache/');
define('DIR_DOWNLOAD', $dir_root.'/download/');
define('DIR_LOGS', $dir_root.'/system/logs/');

// DB
define('DB_DRIVER', 'mysql');
define('DB_HOSTNAME', '10.4.12.46');
define('DB_USERNAME', 'u14oUoae1gFL0');
define('DB_PASSWORD', 'p5Xxk8wkJ3u2T');
define('DB_DATABASE', 'd97fdd23635dc4d0297f698a91a03380f');
define('DB_PREFIX', '');
?>