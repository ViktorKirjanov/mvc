<?

ini_set('display_errors', 0);
error_reporting(E_ALL);


session_start();
define('DS', DIRECTORY_SEPARATOR);

define('ROOT_DIR', dirname(__FILE__));
define('LIB_DIR', ROOT_DIR . DS . 'library');
define('VIEW_DIR', ROOT_DIR . DS . 'views' . DS);
define('MODEL_DIR', ROOT_DIR . DS . 'models' . DS);
define('CONTROLLER_DIR', ROOT_DIR . DS . 'controllers');
define('CONFIG_DIR', ROOT_DIR . DS . 'config');

define('ROUTES_PATH', CONFIG_DIR . DS . 'routes.php');


require_once(LIB_DIR . DS . 'Autoloader.php');
require_once(LIB_DIR . DS . 'Session.php');
require_once (CONFIG_DIR . DS .'database.php');
require_once (CONFIG_DIR . DS .'application.php');

$bootstrap = new Bootstrap();