<?php
class SiteAPI
{

    public function get($segments)
    {

        $action_id = $segments[0];
        $status = ResponseMessenger::STATUS_SUCCESS;
        $message = '';
        $content = '';

        switch ($action_id) {
            default:
                $status    = ResponseMessenger::STATUS_DENY;
                $message   = 'Undefined GET api';
                break;
        }

        ResponseMessenger::json($status, $message, $content);

    }// end function get

    public function post($segments)
    {

        $action_id = $segments[0];
        $status = ResponseMessenger::STATUS_SUCCESS;
        $message = '';
        $content = '';

        switch ($action_id) {
            default:
                $status    = ResponseMessenger::STATUS_DENY;
                $message   = 'Undefined POST api';
                break;
        }

        ResponseMessenger::json($status, $message, $content);

    }// end function post

}// end class SiteAPI
