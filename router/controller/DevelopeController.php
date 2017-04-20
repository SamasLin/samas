<?php
class DevelopeController
{

    private $default_nav = array('nav_bar');

    public function __construct()
    {

        if (!WebService::accessCheck('develope')) {
            WebService::showError(404);
            exit;
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

            case 'database-arrange':
                $page_title = 'Arrange Database Page';
                $view_path = '/develope/database-arrange.php';
                break;

            case 'table-create':
                $page_title = 'Create Table Page';
                $view_path = '/develope/table-create.php';
                break;

            case 'table-drop':
                $page_title = 'Drop Table Page';
                $view_path = '/develope/table-drop.php';
                break;

            case 'table-export':
                $page_title = 'Export Table Page';
                $view_path = '/develope/table-export.php';
                break;

            case 'table-import':
                $page_title = 'Import Table Page';
                $view_path = '/develope/table-import.php';
                break;

            case 'data-truncate':
                $page_title = 'Truncate Data Page';
                $view_path = '/develope/data-truncate.php';
                break;

            case 'data-export':
                $page_title = 'Export Data Page';
                $view_path = '/develope/data-export.php';
                break;

            case 'data-import':
                $page_title = 'Import Data Page';
                $view_path = '/develope/data-import.php';
                break;

            case 'router-create':
                $page_title = 'Create Router Page';
                $view_path = '/develope/router-create.php';
                break;

            case 'php-test':
                $page_title = 'PHP Test Page';
                $view_path = '/develope/php-test.php';
                break;

            case 'phpinfo':
                $page_title = 'PHP Info Page';
                $view_path = '/develope/phpinfo.php';
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

}// end class DevelopeController
