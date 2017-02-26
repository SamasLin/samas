<?php
class DevelopeService
{

    use FileOutput;

    public static function createTable($table_name, $column_array)
    {

        $db_obj = new DatabaseAccess();
        $exist_table_array = $db_obj->getAllTables();

        if (!in_array($table_name, $exist_table_array)) {

            $variable_list = "";

            foreach ($column_array as $column_name => $attribute) {

                switch ($column_name) {

                case 'id':
                case 'is_deleted':
                case 'create_time':
                case 'modify_time':
                case 'delete_time':
                    break;

                default:
                    $variable_list .= '`'.$column_name.'` '.$attribute.', ';
                    break;

                }

            }

            $sql = 'CREATE TABLE IF NOT EXISTS `'.$table_name.'` ( '.
                       '`id` int(11) unsigned NOT NULL, '.
                       $variable_list.
                       '`is_deleted` tinyint(1) unsigned NOT NULL DEFAULT \'0\', '.
                       '`create_time` datetime NOT NULL, '.
                       '`modify_time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\', '.
                       '`delete_time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\' '.
                   ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';
            $create_result = $db_obj->query($sql);
            $sql = "ALTER TABLE `$table_name` ADD PRIMARY KEY (`id`);";
            $primary_key_result = $db_obj->query($sql);
            $sql = "ALTER TABLE `$table_name` MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;";
            $auto_increment_result = $db_obj->query($sql);

            unset($db_obj);

            return $create_result && $primary_key_result && $auto_increment_result;

        } else {

            unset($db_obj);

            return false;

        }

    }// end function createTable

    public static function createModelFile($table_name, $column_array)
    {

        $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table_name)));
        $class_path = MODEL_ROOT.'/'.$class_name.'Model.php';

        if (!file_exists($class_path)) {

            $class_content = str_replace('Name', $class_name, file_get_contents(MODEL_TEMPLATE_FILE));
            $variable_list = "";

            foreach ($column_array as $column_name => $attribute) {

                switch ($column_name) {

                case 'id':
                case 'is_deleted':
                case 'create_time':
                case 'modify_time':
                case 'delete_time':
                    break;

                default:
                    $variable_list .= "    protected \$$column_name;".PHP_EOL;
                    break;

                }

            }

            if (!file_exists(MODEL_ROOT)) {
                self::mkdir(MODEL_ROOT);
            }

            return self::file_put_contents(
                $class_path,
                str_replace('    #variables#'.PHP_EOL, $variable_list, $class_content)
            );

        } else {

            return false;

        }

    }// end function createModelFile

    public static function createDaoFile($table_name)
    {

        $class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $table_name)));
        $class_path = DAO_ROOT.'/'.$class_name.'Dao.php';

        if (!file_exists($class_path)) {

            $class_content = str_replace('Name', $class_name, file_get_contents(DAO_TEMPLATE_FILE));

            if (!file_exists(DAO_ROOT)) {
                self::mkdir(DAO_ROOT);
            }

            return self::file_put_contents($class_path, $class_content);

        } else {

            return false;

        }

    }// end function createDaoFile

    public static function dropTable($table_name)
    {

        $db_obj = new DatabaseAccess();
        $instance_sql = "DROP TABLE `$table_name`";
        $result = $db_obj->query($instance_sql);
        unset($db_obj);

        return $result === true;

    }// end function dropTable

    public static function exportTable($table_name)
    {

        $sql_path = TABLE_SQL_ROOT.'/'.$table_name.'.sql';

        if (!file_exists(SQL_ROOT)) {
            self::mkdir(SQL_ROOT);
        }

        if (!file_exists(TABLE_SQL_ROOT)) {
            self::mkdir(TABLE_SQL_ROOT);
        }

        $sql_content = str_replace('???', $table_name, file_get_contents(TABLE_SQL_TEMPLATE_FILE));
        $db_obj = new DatabaseAccess();
        $column_array = $db_obj->getTableColumns($table_name);
        $column_list = "";
        foreach ($column_array as $column_name => $attribute) {

            $column_list .= "    `$column_name` $attribute,".PHP_EOL;

        }

        return self::file_put_contents($sql_path, str_replace('    ...'.PHP_EOL, $column_list, $sql_content));

    }// end function exportTable

    public static function importTable($table_name)
    {

        $sql_path = TABLE_SQL_ROOT.'/'.$table_name.'.sql';

        if (!file_exists($sql_path)) {

            return false;

        } else {

            $db_obj = new DatabaseAccess();
            $sql = file_get_contents($sql_path);
            $sql_array = explode(';', $sql);
            foreach ($sql_array as $instance_sql) {
                if (strlen($instance_sql) > 1) {
                    $db_obj->query($instance_sql);
                }
            }
            unset($db_obj);

            return true;

        }

    }// end function importTable

    public static function truncateData($table_name)
    {

        $db_obj = new DatabaseAccess();
        $instance_sql = "TRUNCATE `$table_name`";
        $result = $db_obj->query($instance_sql);
        unset($db_obj);

        return $result === true;

    }// end function truncateData

    public static function exportData($table_name, $length=5000)
    {

        $sql_path = DATA_SQL_ROOT.'/'.$table_name;

        if (!file_exists(SQL_ROOT)) {
            self::mkdir(SQL_ROOT);
        }

        if (!file_exists(DATA_SQL_ROOT)) {
            self::mkdir(DATA_SQL_ROOT);
        }

        $db_obj = new DatabaseAccess();
        $column_array = $db_obj->getTableColumns($table_name);

        $sql_content = "INSERT INTO `$table_name`".PHP_EOL."(`id`, ";
        foreach ($column_array as $column_name => $attribute) {
            $sql_content .= "`$column_name`, ";
        }
        $sql_content .= "`is_deleted`, `create_time`, `modify_time`, `delete_time`)".PHP_EOL.
                        "VALUES".PHP_EOL;

        $count_sql = "SELECT COUNT(1) AS cnt FROM `$table_name`";
        $query_instance = $db_obj->select($count_sql);
        $all_data_count = 0;
        foreach ($query_instance as $instance_data) {
            $all_data_count = $instance_data['cnt'];
        }

        for ($page = 1; $page <= ceil($all_data_count / $length); $page++) {

            $offset = ($page - 1) * $length;
            $data_sql = "SELECT * FROM `$table_name` LIMIT $offset, $length";
            $data_rows = $db_obj->select($data_sql);

            foreach ($data_rows as $data) {

                $sql_content .= "('".$data['id']."', ";
                foreach ($column_array as $column_name => $attribute) {

                    $sql_content .= "'".$data[$column_name]."', ";

                }
                $sql_content .= "'".$data['is_deleted']."', ".
                                "'".$data['create_time']."', ".
                                "'".$data['modify_time']."', ".
                                "'".$data['delete_time']."'".
                                "),".PHP_EOL;

            }

            if (!self::file_put_contents($sql_path.'_'.$page.'.sql', substr($sql_content, 0, -2).';')) {

                return false;

            }

        }

        return true;

    }// end function exportData

    public static function importData($table_name)
    {

        $page = 1;
        $db_obj = new DatabaseAccess();

        $sql = "TRUNCATE `$table_name`";
        $db_obj->query($sql);

        while (true) {

            $sql_path = DATA_SQL_ROOT.'/'.$table_name.'_'.$page.'.sql';

            if (!file_exists($sql_path)) {

                break;

            } else {

                $sql = file_get_contents($sql_path);
                $import_result = $db_obj->insert($sql);

                if (!$import_result) {

                    return false;

                }

            }

            $page++;

        }

        unset($db_obj);

        return true;

    }// end function importData

    public static function createControllerFile($type_name)
    {

        $file_path = CONTROLLER_ROOT.'/'.$type_name.'Controller.php';

        if (!file_exists($file_path)) {

            $file_content = str_replace('Type', $type_name, file_get_contents(CONTROLLER_TEMPLATE_FILE));

            if (!file_exists(CONTROLLER_ROOT)) {
                self::mkdir(CONTROLLER_ROOT);
            }

            return self::file_put_contents($file_path, $file_content);

        } else {

            return false;

        }

    }// end function createControllerFile

    public static function createActionFile($type_name)
    {

        $file_path = ACTION_ROOT.'/'.$type_name.'Action.php';

        if (!file_exists($file_path)) {

            $file_content = str_replace('Type', $type_name, file_get_contents(ACTION_TEMPLATE_FILE));

            if (!file_exists(ACTION_ROOT)) {
                self::mkdir(ACTION_ROOT);
            }

            return self::file_put_contents($file_path, $file_content);

        } else {

            return false;

        }

    }// end function createActionFile

    public static function createAPIFile($type_name)
    {

        $file_path = API_ROOT.'/'.$type_name.'API.php';

        if (!file_exists($file_path)) {

            $file_content = str_replace('Type', $type_name, file_get_contents(API_TEMPLATE_FILE));

            if (!file_exists(API_ROOT)) {
                self::mkdir(API_ROOT);
            }

            return self::file_put_contents($file_path, $file_content);

        } else {

            return false;

        }

    }// end function createAPIFile

}// end class DevelopeService
