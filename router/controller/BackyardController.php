<?php
class BackyardController
{

    private $default_nav = array('nav_bar', 'backyard_breadcrumbs');

    public function __construct()
    {

        if (!WebService::accessCheck('backyard')) {
            WebService::redirectPage();
        }

    }

    public function get($segments)
    {

        $action_id  = $segments[0];
        $page_title = '';
        $view_path  = '';
        $nav_config = $this->default_nav;
        $page_data  = array();

        switch ($action_id) {

            case empty($action_id) ? true : false:
            case preg_match('/^index(.*)/',$action_id) ? true : false:
                $page_title = '後台首頁';
                $view_path = '/backyard/index.php';
                break;

            default:
                WebService::showError(404);
                exit;

        }

        PJAXLoader::run($page_title, $view_path, $nav_config, $page_data);

    }// end function get

    public function post($segments)
    {

        $action_id  = $segments[0];
        $page_title = '';
        $view_path  = '';
        $nav_config = $this->default_nav;
        $page_data  = array();

        switch ($action_id) {

            case empty($action_id) ? true : false:
            case preg_match('/^index(.*)/',$action_id) ? true : false:
            default:
                WebService::showError(404);
                exit;

        }

        PJAXLoader::run($page_title, $view_path, $nav_config, $page_data);

    }// end function post

}// end class BackyardController
