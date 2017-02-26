<?php
class PJAXLoader
{

    public static function isPJAX()
    {

        if (   array_key_exists('HTTP_X_PJAX', $_SERVER)
            && $_SERVER['HTTP_X_PJAX'] === 'true'
        ) {
            return true;
        } else {
            return false;
        }

    }// end function isPJAX

    public static function getPJAXContainer()
    {

        return $_SERVER['HTTP_X_PJAX_CONTAINER'];

    }// end function getPJAXContainer

    public static function run($page_title, $url, $nav_config = array())
    {

        $view_path = PAGE_ROOT.$url;
        if (!file_exists($view_path)) {
            echo 'View file missing:'.$view_path;
        } else if (self::isPJAX() && self::getPJAXContainer() == '#main-section') {
            echo '<script>document.title=("'.$page_title.'");</script>';
            WebService::renderNav($nav_config, $url);
            include $view_path;
        } else {
            include LAYOUT_ROOT.'/main-layout.php';
        }

    }// end function run

}// end class PJAXLoader
