<?php
class DevelopeAction
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

            case 'eval-code':
                if (!WebService::accessCheck('develope')) {
                    WebService::redirectPage();
                }
                $code = $_POST['code'];
                include COMPONENT_ROOT.'/develope/eval-code.php';
                exit;

            case 'create-table':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $table_name   = $_POST['table_name'];
                $column_array = array();

                foreach ($_POST as $key => $value) {
                    switch ($key) {
                        case 'table_name':
                        case 'default_value_radio':
                            break;

                        default:
                            $column_array[$key] = $value;
                            break;
                    }
                }

                $create_table = DevelopeService::createTable($table_name, $column_array);
                $create_model = DevelopeService::createModelFile($table_name, $column_array);
                $create_dao   = DevelopeService::createDaoFile($table_name);

                if (!$create_table || !$create_model || !$create_dao) {
                    $status = ResponseMessenger::STATUS_FAIL;
                }
                break;

            case 'drop-table':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $table_list          = $_POST['table_list'];
                $table_array         = explode(',', $table_list);
                $success_table_array = array();
                $fail_table_array    = array();

                foreach ($table_array as $table_name) {
                    if (DevelopeService::dropTable($table_name)) {
                        $success_table_array[] = $table_name;
                    } else {
                        $fail_table_array[] = $table_name;
                    }
                }

                $message = '成功刪除 '.count($success_table_array).' 個 Table';
                $content = array(
                    "success" => implode(', ', $success_table_array),
                    "fail"    => implode(', ', $fail_table_array)
                );
                break;

            case 'export-table':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $table_list          = $_POST['table_list'];
                $table_array         = explode(',', $table_list);
                $success_table_array = array();
                $fail_table_array    = array();

                foreach ($table_array as $table_name) {
                    if (DevelopeService::exportTable($table_name)) {
                        $success_table_array[] = $table_name;
                    } else {
                        $fail_table_array[] = $table_name;
                    }
                }

                $message = '成功匯出 '.count($success_table_array).' 個 Table';
                $content = array(
                    "success" => implode(', ', $success_table_array),
                    "fail"    => implode(', ', $fail_table_array)
                );
                break;

            case 'import-table':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $table_list          = $_POST['table_list'];
                $table_array         = explode(',', $table_list);
                $success_table_array = array();
                $fail_table_array    = array();

                foreach ($table_array as $table_name) {
                    if (DevelopeService::importTable($table_name)) {
                        $success_table_array[] = $table_name;
                    } else {
                        $fail_table_array[] = $table_name;
                    }
                }

                $message = '成功匯入 '.count($success_table_array).' 個 Table';
                $content = array(
                    "success" => implode(', ', $success_table_array),
                    "fail"    => implode(', ', $fail_table_array)
                );
                break;

            case 'truncate-data':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $table_list          = $_POST['table_list'];
                $table_array         = explode(',', $table_list);
                $success_table_array = array();
                $fail_table_array    = array();

                foreach ($table_array as $table_name) {
                    if (DevelopeService::truncateData($table_name)) {
                        $success_table_array[] = $table_name;
                    } else {
                        $fail_table_array[] = $table_name;
                    }
                }

                $message = '成功清空並重置 '.count($success_table_array).' 個 Table';
                $content = array(
                    "success" => implode(', ', $success_table_array),
                    "fail"    => implode(', ', $fail_table_array)
                );
                break;

            case 'export-data':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $table_list          = $_POST['table_list'];
                $table_array         = explode(',', $table_list);
                $success_table_array = array();
                $fail_table_array    = array();

                foreach ($table_array as $table_name) {
                    if (DevelopeService::exportData($table_name)) {
                        $success_table_array[] = $table_name;
                    } else {
                        $fail_table_array[] = $table_name;
                    }
                }

                $message = '成功匯出 '.count($success_table_array).' 個 Table';
                $content = array(
                    "success" => implode(', ', $success_table_array),
                    "fail"    => implode(', ', $fail_table_array)
                );
                break;

            case 'import-data':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $table_list          = $_POST['table_list'];
                $table_array         = explode(',', $table_list);
                $success_table_array = array();
                $fail_table_array    = array();

                foreach ($table_array as $table_name) {
                    if (DevelopeService::importData($table_name)) {
                        $success_table_array[] = $table_name;
                    } else {
                        $fail_table_array[] = $table_name;
                    }
                }

                $message = '成功匯入 '.count($success_table_array).' 個 Table';
                $content = array(
                    "success" => implode(', ', $success_table_array),
                    "fail"    => implode(', ', $fail_table_array)
                );
                break;

            case 'arrange-database':
                if (!WebService::accessCheck('develope')) {
                    WebService::redirectPage();
                }
                include COMPONENT_ROOT.'/develope/arrange-database.php';
                exit;

            case 'create-router':
                if (!WebService::accessCheck('develope')) {
                    $status = ResponseMessenger::STATUS_DENY;
                    break;
                }
                $router_name = '';
                $router_name_segments = explode('_', $_POST['router_name']);
                foreach ($router_name_segments as $word) {
                    $router_name .= ucfirst($word);
                }
                $success_file_array = array();
                $fail_file_array    = array();

                if ($_POST['create_controller']) {
                    if (DevelopeService::createControllerFile($router_name)) {
                        $success_file_array[] = $router_name.'Controller';
                    } else {
                        $fail_file_array[] = $router_name.'Controller';
                    }
                }

                if ($_POST['create_action']) {
                    if (DevelopeService::createActionFile($router_name)) {
                        $success_file_array[] = $router_name.'Action';
                    } else {
                        $fail_file_array[] = $router_name.'Action';
                    }
                }

                if ($_POST['create_api']) {
                    if (DevelopeService::createAPIFile($router_name)) {
                        $success_file_array[] = $router_name.'API';
                    } else {
                        $fail_file_array[] = $router_name.'API';
                    }
                }

                $message = '成功建立 '.count($success_file_array).' 個檔案';
                $content = array(
                    "success" => implode(', ', $success_file_array),
                    "fail"    => implode(', ', $fail_file_array)
                );
                break;

            default:
                $status  = ResponseMessenger::STATUS_DENY;
                $message = 'Undefined POST action';
                break;

        }

        ResponseMessenger::json($status, $message, $content);

    }// end function post

}// end class DevelopeAction
