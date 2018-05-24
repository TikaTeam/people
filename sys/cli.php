<?php
namespace Framework;

require_once 'config.php';
require_once 'database.php';

set_error_handler('\Framework\handleError');
set_exception_handler('\Framework\myException');

class cli{
    public $db;
    public $load;

    function __construct()
    {
		if(config::$dbname)
			$this->db=new database(config::$dbhost, config::$dbuser, config::$dbpass, config::$dbname, config::$dbencoding);

		$this->load=new loader();
    }
}

class loader{
    function view($path, $data=null)
    {
        if($data)
            extract($data);

        require_once './app/view/'. $path . '.php';
    }
}

class router{
	function __construct()
    {
        $uri= isset( $_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : config::$default;
        $uri=trim($uri, '/');
        $uri= explode('/', $uri);

        $className=$uri[0];
        $methodName=isset($uri[1]) ? $uri[1] : 'index';

        array_shift( $uri);
        array_shift( $uri);

        $controllerFile= './app/controller/'. $className. '.php';

        if(is_file($controllerFile))
        {
            require_once $controllerFile;
            if(class_exists( $className))
            {
                if( method_exists($className, $methodName))
                {
                    $class= new $className;
                    call_user_func_array(array($class, $methodName), $uri);
                }
                else
                {
                    throw new \Exception('Error Function not found',666);
                }
            }
            else
            {
                throw new \Exception('Error class not found',666);
            }
        }
        else
        {
            throw new \Exception('.....File not found.......',666);
        }
    }
}

function handleError($errno, $errstr,$error_file,$error_line) {
    $title= 'Error '. $errno;
    $heading= 'Error '.$errno;
    $message= "<p><b>Filename:</b> $error_file - Line: $error_line</p><p>$errstr</p>";

    require_once './app/error/error_general.php';
    exit;
}

function myException(\Exception $exception) {
    $title= 'Error ' . $exception->getCode();
    $heading= 'Error ' . $exception->getCode();
    $message= "<p><b>Filename:</b> {$exception->getFile()} - Line: {$exception->getLine()}</p>
<p>{$exception->getMessage()}</p>
<p><b>Trace:</b> {$exception->getTraceAsString()}</p>
<p><b>Previous:</b> {$exception->getPrevious()}</p>";

    require_once './app/error/error_general.php';
    exit;
    echo "<b>Exception:</b> " . $exception->getMessage();
}
function show_404()
{
    $title= '404 Page Not Found';
    $heading= $title;
    $message= "<p>The page you requested was not found.</p>";

    require_once './app/error/error_general.php';
    exit;
}


