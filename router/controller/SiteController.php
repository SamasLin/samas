<?php
class SiteController
{

    private $default_nav = array('nav_bar');

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
                $page_title = '首頁';
                $view_path = '/index.php';
                break;

            case 'login':
                if (WebService::isLogin()) {
                    WebService::redirectPage(WebService::getRedirectTarget());
                }
                $page_title = '登入';
                $view_path = '/site/login.php';
                break;

            case 'signup':
                if (WebService::isLogin()) {
                    WebService::redirectPage(WebService::getRedirectTarget());
                }
                $page_title = '註冊';
                $view_path = '/site/signup.php';
                break;

            case 'logout':
                if (WebService::isLogin()) {
                    $login_user_obj = WebService::getLoginUser();
                    $login_user_obj->csrf_token = 'offline';
                    $login_user_obj->save();
                    WebService::logout();
                }
                WebService::redirectPage(WebService::getRedirectTarget());
                return;

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

}// end class SiteController
