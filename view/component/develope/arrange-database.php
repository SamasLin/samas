<?php
include DB_CONFIG_FILE;

echo '<pre>';

// proccess database
echo "Proccess database `$database_name`:".PHP_EOL;
// check connection
echo "\tCheck connection...";
$connection = mysqli_connect($database_host, $database_user, $database_password);
if (mysqli_connect_errno()) {
    echo PHP_EOL."\t=>Failed to connect to MySQL: ".mysqli_connect_error().PHP_EOL;
    exit;
}
echo 'ok'.PHP_EOL;
echo "\tCreate database `$database_name`...";
$database_selected = mysqli_select_db($connection, $database_name);
if (!$database_selected) {
    $sql = "CREATE DATABASE `$database_name`";
    if (!mysqli_query($connection, $sql)) {
        echo PHP_EOL."\t\t=>Error when creating database `$database_name`: ".mysql_error().PHP_EOL;
        exit;
    }
    echo 'done'.PHP_EOL;
} else {
    echo 'exists'.PHP_EOL;
}

// create tables
$db_obj = new DatabaseAccess();
$new_table_array = array();
foreach (glob(TABLE_SQL_ROOT.'/*.sql') as $sql_file) {
    $new_table_array[] = str_replace('.sql', '', str_replace(TABLE_SQL_ROOT.'/', '', $sql_file));
}
foreach ($new_table_array as $table_name) {
    $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table_name)));
    echo "\tProccess table `$table_name`:".PHP_EOL;
    echo "\t\tEnsure table `$table_name`...";
    if (DevelopeService::importTable($table_name)) {
        echo 'ok'.PHP_EOL;

        // sync model file
        $class_path = MODEL_ROOT.DIRECTORY_SEPARATOR.$class_name.'Model.php';
        echo "\t\tCreate model file \"/class/model/$class_name"."Model.php\"...";
        if (file_exists($class_path)) {
            echo "exists".PHP_EOL;
        } else {
            $column_list = $db_obj->getTableColumns($table_name);
            if (DevelopeService::createModelFile($table_name, $column_list)) {
                echo 'ok'.PHP_EOL;
            } else {
                echo 'fail'.PHP_EOL;
            }
        }

        // sync dao file
        $class_path = DAO_ROOT.DIRECTORY_SEPARATOR.$class_name.'Dao.php';
        echo "\t\tCreate dao file \"/class/dao/$class_name"."Dao.php\"...";
        if (file_exists($class_path)) {
            echo "exists".PHP_EOL;
        } else {
            $column_list = $db_obj->getTableColumns($table_name);
            if (DevelopeService::createDaoFile($table_name)) {
                echo 'ok'.PHP_EOL;
            } else {
                echo 'fail'.PHP_EOL;
            }
        }

        // sync table data
        echo "\t\tImport `$table_name` data...";
        if (DevelopeService::importData($table_name)) {
            echo 'ok'.PHP_EOL;
        } else {
            echo 'fail'.PHP_EOL;
        }

    } else {

        echo 'fail'.PHP_EOL;

    }

}

echo '</pre>';
?>