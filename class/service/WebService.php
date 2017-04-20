<?php
class WebService
{

    public static $login_user_obj = null;
    public static $site_url = array(
        '/site/login',
        '/site/signup',
        '/site/logout'
    );

    public static function renderNav($nav_config, $url)
    {

        foreach ($nav_config as $nav) {
            $words = array_map('ucfirst', explode('_', $nav));
            $method_name = 'get'.implode('', $words);
            self::$method_name($url);
        }

    }// end function renderNav

    public static function redirectPage($destination = '/index')
    {

        echo '<script>window.location.href = "'.$destination.'";</script>';
        exit;

    }// end function redirectPage

    public static function getBackyardMap()
    {

        return array(
            'list' => array(
                'title' => 'url'
            )
        );

    }// end function getBackyardMap

    public static function getPureURI()
    {
        return preg_replace('/\?(.*)/', '', $_SERVER['REQUEST_URI']);
    }// end function getPureURI

    public static function getRedirectTarget()
    {

        $redirect_target = self::getPureURI();

        if (!empty($_GET['redirect'])) {
            $redirect_target = $_GET['redirect'];
        }

        if (in_array($redirect_target, self::$site_url)) {
            $redirect_target = '/index';
        }

        return $redirect_target;

    }// end function getRedirectTarget

    public static function getRedirectQuery()
    {

        return '?redirect='.self::getRedirectTarget();

    }// end function getRedirectQuery

    public static function accessCheck($section)
    {

        if (DEV_MODE) {

            return true;

        }

        switch ($section) {

        case 'backyard':
        case 'develope':

            if (self::isLogin() && $_COOKIE['user_id'] == '1') {

                return true;

            }

            break;

        }

        return false;

    }// end function accessCheck

    public static function encryptPwd($password)
    {

        return md5('PWD'.$password.'0lO1oI');

    }// end function encryptPws

    public static function getLoginUser($user_id = 0)
    {
        $user_id = !empty($user_id) ? $user_id : $_COOKIE['user_id'];
        if (is_null(self::$login_user_obj)) {
            self::$login_user_obj = new UserModel($user_id);
        }
        return self::$login_user_obj;

    }// end function getLoginUser

    public static function genCsrfToken($user_id)
    {

        return md5('CSRF'.$user_id.'0lO1oI'.time());

    }// end function genCsrfToken

    public static function getUserAuth($user_id, $csrf_token)
    {

        return md5('AUTH'.$user_id.'0lO1oI'.$csrf_token);

    }// end function getUserAuth

    public static function getCsrfToken()
    {

        $csrf_token = '';

        if (self::isLogin()) {
            $login_user_obj = self::getLoginUser();
            $csrf_token = $login_user_obj->csrf_token;
        }

        return $csrf_token;

    }// public function getCsrfToken

    public static function renderCsrfInput()
    {

        return '<input type="hidden" name="csrf_token" value="'.self::getCsrfToken().'">';

    }// end function renderCsrfInput

    public static function isLogin()
    {

        if (   isset($_COOKIE['user_id'])
            && !empty($_COOKIE['user_id'])
            && isset($_COOKIE['user_auth'])
            && !empty($_COOKIE['user_auth'])
        ) {
            $login_user_obj = self::getLoginUser();
            if (   $login_user_obj->csrf_token != 'offline'
                && self::getUserAuth($_COOKIE['user_id'], $login_user_obj->csrf_token) == $_COOKIE['user_auth']
            ) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }// end function isLogin

    public static function login($user_id)
    {

        $code = 0;
        $parameter = '';

        if (!self::isLogin()) {

            $csrf_token = self::genCsrfToken($user_id);

            setcookie('user_id', $user_id, false, "/", false);
            setcookie('user_auth', self::getUserAuth($user_id, $csrf_token), false, "/", false);

            $login_user_obj = self::getLoginUser($user_id);
            $login_user_obj->csrf_token = $csrf_token;
            $login_user_obj->save();

        }

    }// end function login

    public static function logout()
    {

        setcookie('user_id', '', time() - 60000, "/");
        setcookie('user_auth', '', time() - 60000, "/");

    }// end function logout

    public static function showError($error_code = 0)
    {

        switch ($error_code) {
        case '0':
            $page_title = '首頁';
            $view_path = '/index.php';
            break;

        case '405':
            $page_title = '存取方式錯誤';
            $view_path = '/error/method-not-allowed.php';
            break;

        case '500':
            $page_title = '系統發生錯誤';
            $view_path = '/error/service-unavailable.php';
            break;

        case '404':
        default:
            $page_title = '頁面找不到';
            $view_path = '/error/page-not-found.php';
            break;

        }
        PJAXLoader::run($page_title, $view_path, array('nav_bar'));
        exit;

    }// end function showError

    private static function getNavBar($url)
    {

        $nav_array = array(
            '首頁' => '/index'
        );

        if (WebService::accessCheck('backyard')) {
            $nav_array['後台'] = '/backyard/index';
        }
        if (WebService::accessCheck('develope')) {
            $nav_array['開發'] = array(
                '測試 PHP'  => '/develope/php-test',
                'divider',
                '建立資料表' => '/develope/table-create',
                '刪除資料表' => '/develope/table-drop',
                '資料表處理' => array(
                    '匯出資料表結構' => '/develope/table-export',
                    '匯入資料表結構' => '/develope/table-export'
                ),
                'divider',
                '清空資料表' => '/develope/data-truncate',
                '資料表內容' => array(
                    '匯出資料表內容' => '/develope/data-export',
                    '匯入資料表內容' => '/develope/data-import'
                ),
                'divider',
                '同步資料庫' => '/develope/database-arrange',
                'divider',
                '網站接口' => '/develope/router-create',
                'divider',
                'PHP Info' => '/develope/phpinfo'
            );
        }

        include COMPONENT_ROOT.'/navbar.php';

    }// end function getNavBar

    private static function getBackyardBreadcrumbs($url)
    {

        $map = self::getBackyardMap();
        include COMPONENT_ROOT.'/backyard/breadcrumbs.php';

    }// end function getBackyardBreadcrumbs

}// end class WebService
