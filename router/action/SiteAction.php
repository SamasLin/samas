<?php
class SiteAction
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

            case 'login':
                $user_model_obj = new UserModel();
                $user_dao_obj = new UserDao();

                $account  = trim($_POST['account']);
                $password = WebService::encryptPwd($_POST['password']);

                $check_password_condition = array(
                    'field' => 'id, password',
                    'where' => 'account = :account OR email = :email',
                    'param' => array(
                        ':account' => $account,
                        ':email' => $account
                    )
                );

                $user_id = 0;
                $user_pwd = '';
                $query_instance = $user_dao_obj->select($check_password_condition);
                foreach ($query_instance as $instance_data) {
                    $user_id = $instance_data['id'];
                    $user_pwd = $instance_data['password'];
                }

                if (empty($user_id)) {
                    $status = ResponseMessenger::STATUS_EMPTY;
                    $message = '帳號不存在';
                } else if ($user_pwd != $password) {
                    $status = ResponseMessenger::STATUS_DENY;
                    $message = '帳號或密碼錯誤';
                } else {
                    WebService::login($user_id);
                }

                unset($user_dao_obj);
                unset($user_model_obj);
                break;

            case 'signup':
                $user_model_obj = new UserModel();
                $user_dao_obj = new UserDao();

                $user_data = array();
                $user_data['name']     = trim($_POST['name']);
                $user_data['account']  = trim($_POST['account']);
                $user_data['email']    = trim($_POST['email']);
                $user_data['password'] = WebService::encryptPwd($_POST['password']);
                $user_model_obj->set($user_data);

                $check_account_condition = array(
                    'where' => 'account = :account',
                    'param' => array(
                        ':account' => $user_model_obj->account
                    )
                );
                $check_email_condition = array(
                    'where' => 'email = :email',
                    'param' => array(
                        ':email' => $user_model_obj->email
                    )
                );
                if (count($user_dao_obj->select($check_account_condition)) > 0) {
                    $status = 'fail';
                    $message = '帳號已存在';
                } else if (count($user_dao_obj->select($check_email_condition)) > 0) {
                    $status = 'fail';
                    $message = 'Email已註冊';
                } else {
                    $user_id = $user_model_obj->save();
                    WebService::login($user_id);
                }

                unset($user_dao_obj);
                unset($user_model_obj);
                break;

            default:
                $status  = ResponseMessenger::STATUS_DENY;
                $message = 'Undefined POST action';
                break;

        }

        ResponseMessenger::json($status, $message, $content);

    }// end function post

}// end class SiteAction
