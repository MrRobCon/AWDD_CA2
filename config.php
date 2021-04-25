<?php
define('APP_URL', 'http://localhost/shopping-cart-website-MrRobCon');
define("UPLOAD_DIR", "uploads");

define('DB_SERVER', 'localhost');
define('DB_DATABASE', 'ca2_john');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

set_include_path(
  get_include_path() . PATH_SEPARATOR . dirname(__FILE__)
);

require_once "vendor/autoload.php";
require_once "lib/global.php";

use BookWorms\Http\HttpRequest;

if (!isset($request)) {
  $request = new HttpRequest();
}
