<?php
class TypeAction
{

    public function get($segments)
    {

        $action_id = $segments[0];

        switch ($action_id) {

        default:
            echo 'Undefined GET action';
            break;

        }

    }// end function get

    public function post($segments)
    {

        $action_id = $segments[0];
        $status    = ResponseMessenger::STATUS_SUCCESS;
        $message   = '';
        $content   = '';

        switch ($action_id) {

            default:
                $status  = ResponseMessenger::STATUS_DENY;
                $message = 'Undefined POST action';
                break;

        }

        ResponseMessenger::json($status, $message, $content);

    }// end function post

}// end class TypeAction
