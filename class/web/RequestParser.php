<?php
/**
 * request parser
 * @author samas.lin
 */
class RequestParser
{

    private $_router   = false;
    private $_segments = false;

    /**
     * request parser construct
     * @author samas.lin
     */
    public function __construct()
    {
        $this->_segments = explode('/', WebService::getPureURI());
        array_shift($this->_segments);// first element is useless.
        $type = array_shift($this->_segments);

        if (empty($type) || empty($this->_segments)) {

            PJAXLoader::run('首頁', '/index.php', array('nav_bar'));
            exit;

        }

        switch ($type) {
            case 'api':
                $router_root = API_ROOT;
                $action = array_shift($this->_segments);
                $suffix = 'API';
                break;
            case 'action':
                $router_root = ACTION_ROOT;
                $action = array_shift($this->_segments);
                $suffix = 'Action';
                break;
            default:
                $router_root = CONTROLLER_ROOT;
                $action = $type;
                $suffix = 'Controller';
                break;
        }

        $router_name = ucfirst($action).$suffix;
        while (count($this->_segments) > 1) {
            if (!is_dir($router_root.DIRECTORY_SEPARATOR.$action)) {
                break;
            }
            $router_root .= DIRECTORY_SEPARATOR.$action;
            $action = array_shift($this->_segments);
            $router_name = ucfirst($action).$suffix;

        }

        if (!class_exists($router_name)) {

            $router_file_path = $router_root.'/'.$router_name.'.php';

            if (file_exists($router_file_path)) {

                include $router_file_path;

            } else {

                WebService::showError(404);

            }

        }// end if (!class_exists($router_name))

        $this->_router = new $router_name;

    }// end function __construct

    /**
     * request parse proccess
     * @author samas.lin
     */
    public function run()
    {

        if ($this->_router === false) {

            WebService::showError('Empty router');

        }// end if ($this->_router === false)

        if (empty($this->_segments)) {

            WebService::showError('Missing action parameter');

        }// end if (empty($this->_segments))

        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if (!method_exists($this->_router, $method)) {

            WebService::showError(405);

        }// end if (!method_exists($this->_router, $method))

        $arguments = $this->_segments;
        $this->_router->$method($arguments);

    }// end function run

}// end class RequestParser