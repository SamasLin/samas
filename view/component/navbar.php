<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <ul class="nav">
            <?php
            function parseNavArray($nav_array, $page_url, $level = 1) {

                $output = "";

                foreach ($nav_array as $nav_title => $nav_url) {

                    if (is_array($nav_url)) {

                        $nav_class = '';
                        if (in_array_r(str_replace('.php', '', $page_url), $nav_url)) {

                            $nav_class = ' active';

                        }// end if (in_array_r($page_url, $nav_url))

                        if ($level == 1) {

                            $output .= '<li class="dropdown'.$nav_class.'">'.
                                           '<a class="dropdown-toggle" data-toggle="dropdown">'.
                                               $nav_title.' <b class="caret"></b>'.
                                           '</a>'.
                                           '<ul class="dropdown-menu">'.
                                               parseNavArray($nav_url, $page_url, $level + 1).
                                           '</ul>'.
                                       '</li>';

                        } else {// end if ($level == 1)

                            $output .= '<li class="dropdown-submenu">'.
                                           '<a>'.$nav_title.'</a>'.
                                           '<ul class="dropdown-menu">'.
                                               parseNavArray($nav_url, $page_url, $level + 1).
                                           '</ul>'.
                                       '</li>';

                        }// end if ($level == 1) else

                    } else if ($nav_url == "divider") {// end if (is_array($nav_url))

                        $output .= '<li class="divider"></li>';

                    } else if ($nav_url == str_replace('.php', '', $page_url)) {// end if ($nav_url == "divider")

                        if ($level == 1) {

                            $output .= '<li class="active"><a>'.$nav_title.'</a></li>';

                        } else {// end if ($level == 1)

                            $output .= '<li class="disabled"><a>'.$nav_title.'</a></li>';


                        }// end if ($level == 1) else

                    } else {// end if ($nav_url == $page_url)

                        $output .= '<li><a href="'.$nav_url.'" class="main-pjax">'.$nav_title.'</a></li>';

                    }// end if ($nav_url == $page_url) else

                }// end foreach ($nav_array as $nav_title => $nav_url)

                return $output;

            }// end function parseNavArray

            echo parseNavArray($nav_array, $url);
            ?>
        </ul>
        <?php
        if (MEMBER_SYSTEM) {

            $right_nav_array = array();
            $logout_script = '';

            if (WebService::isLogin()) {
                $login_user_obj = WebService::getLoginUser();
                $right_nav_array['登出'] = '/site/logout';
            } else {
                $right_nav_array['登入'] = '/site/login';
                $right_nav_array['註冊'] = '/site/signup';
                $logout_script = '<script>document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^\s?/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });</script>';
            }
        ?>
        <ul class="nav pull-right">
            <li><a class="brand" style="cursor: default; color: #ffffff;"><?php echo StringUtil::encode($login_user_obj->name); ?></a></li>
            <?php
            foreach ($right_nav_array as $nav_title => $nav_url) {

                if ($nav_url == '/site/logout') {
            ?>
            <li><a href="<?php echo $nav_url.WebService::getRedirectQuery(); ?>"><?php echo $nav_title; ?></a></li>
            <?php
                } else if ($nav_url == str_replace('.php', '', $url)) {
            ?>
            <li class="active"><a><?php echo $nav_title; ?></a></li>
            <?php
                } else {
            ?>
            <li><a href="<?php echo $nav_url.WebService::getRedirectQuery(); ?>" class="main-pjax"><?php echo $nav_title; ?></a></li>
            <?php
                }
            }
            ?>
        </ul>
        <?php
            echo $logout_script;
        }
        ?>
    </div>
</div>