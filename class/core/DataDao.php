<?php
abstract class DataDao
{

    protected $db_obj;
    protected $table_name;
    protected static $default_params = array(
        'field'  => '*',
        'where'  => '',
        'param'  => array(),
        'group'  => '',
        'order'  => '',
        'offset' => 0,
        'length' => 0,
        'join'   => array(
            0 => array(
                'table' => '',
                'on'    => ''
            )
        )
    );

    public function __construct()
    {

        $this->db_obj     = new DatabasePDO();
        $this->table_name = strtolower(
            preg_replace(
                '/([^\s])([A-Z])/',
                '\1_\2',
                str_replace('Dao', '', get_class($this))
            )
        );

    }// end function __construct

    public function insert($insert_data)
    {

        $field_array = array();
        $value_array = array();
        $param       = array();
        foreach ($insert_data as $key => $value) {
            $field_array[] = '`'.$key.'`';
            $value_array[] = ':'.$key;
            $param[':'.$key] = $value;
        }
        $insert_sql = 'INSERT INTO '.$this->table_name.' ('.
                      implode(', ', $field_array).
                      ') VALUES ('.
                      implode(', ', $value_array).
                      ')';
        return $this->db_obj->insert($insert_sql, $param);

    }// end function insert

    public function select($query_params = array())
    {

        $query_params = array_merge(self::$default_params, $query_params);

        $select_sql = $this::getSelectSql($this->table_name, $query_params);

        $query_instance = $this->db_obj->select($select_sql, $query_params['param']);

        return $query_instance;

    }// end function select

    public function update($update_data, $where, $param)
    {

        $update_sql = 'UPDATE '.$this->table_name.' SET ';
        $field_string = '';
        foreach ($update_data as $key => $value) {
            $update_sql .= $key.' = :'.$key.', ';
            $param[':'.$key] = $value;
        }
        $update_sql = substr($update_sql, 0, -2).' ';
        $update_sql .= ' WHERE '.$where.' ';
        return $this->db_obj->update($update_sql, $param);

    }// end function update

    public function delete($where, $param, $limit = 1)
    {

        $delete_sql = 'DELETE FROM '.$this->table_name.' '.
                      'WHERE '.$where.' ';
        if ($limit > 0) {
            $delete_sql .= 'LIMIT '.$limit;
        }
        return $this->db_obj->delete($delete_sql, $param);

    }// end function delete

    protected function appendIsDeleted($query_params, $is_deleted)
    {
        if (in_array($is_deleted, array(0, 1), true)) {
            if (!empty($query_params['where'])) {
                $query_params['where'] = '('.$query_params['where'].') AND s.is_deleted = '.$is_deleted;
            } else {
                $query_params['where'] = 's.is_deleted = '.$is_deleted;
            }
        }
        return $query_params;
    }// end funciton appendIsDeleted

    private static function getSelectSql($table_name, $query_params)
    {

        $query_params = array_merge(self::$default_params, $query_params);

        $select_sql = 'SELECT '.$query_params['field'].' '.
                      'FROM '.$table_name.' as s ';

        if (count($query_params['join']) > 0) {
            foreach ($query_params['join'] as $index => $join_data) {
                if (!empty($join_data['table']) && !empty($join_data['on'])) {
                    $select_sql .= 'LEFT JOIN '.$join_data['table'].' as t'.$index.' '.
                                   'ON '.$join_data['on'].' ';
                }
            }
        }

        if (!empty($query_params['where'])) {
            $select_sql .= 'WHERE '.$query_params['where'].' ';
        }

        if (!empty($query_params['group'])) {
            $select_sql .= 'GROUP BY '.$query_params['group'].' ';
        }

        if (!empty($query_params['order'])) {
            $select_sql .= 'ORDER BY '.$query_params['order'].' ';
        }

        if ($query_params['length'] > 0) {
            if ($query_params['offset'] > 0) {
                $select_sql .= 'LIMIT '.$query_params['offset'].', '.$query_params['length'];
            } else {
                $select_sql .= 'LIMIT '.$query_params['length'];
            }
        }

        return $select_sql;
    }

    public function __call($function_name, $arguments)
    {

        $class_name = get_class($this);

        $method_name_temp = preg_replace(
            '/([A-Z])/',
            '_\1',
            $function_name
        );
        $word_array = explode('_', $method_name_temp);
        $type = array_pop($word_array);
        if (!in_array($type, array('List', 'Count'))) {
            throw new RuntimeException('Call to undefined method: '.$class_name.'->'.$function_name.'()');
        }

        $codition_method = implode('', $word_array).'Condition';
        if (!method_exists($class_name, $codition_method)) {
            $message = 'Missing condition method: '.$function_name.'Condition() in '.$class_name;
            throw new RuntimeException($message);
        }

        $obj = $this;
        $query_params = call_user_func_array(array($obj, $codition_method), $arguments);
        if ($type == 'Count') {
            $result = 0;
            $query_params['field'] = 'COUNT(1) AS cnt';
            $query_instance = $obj->select($query_params);
            foreach ($query_instance as $instance_data) {
                $result = $instance_data['cnt'];
            }
        } else {
            $result = $obj->select($query_params);
        }

        return $result;

    }// end function __call

    public static function __callStatic($function_name, $arguments)
    {

        $class_name = get_called_class();

        $method_name_temp = preg_replace(
            '/([A-Z])/',
            '_\1',
            $function_name
        );
        $word_array = explode('_', $method_name_temp);
        $type = array_pop($word_array);
        if (!in_array($type, array('List', 'Count'))) {
            throw new RuntimeException('Call to undefined static method: '.$class_name.'::'.$function_name.'()');
        }

        $codition_method = implode('', $word_array).'Condition';
        $obj = new $class_name();
        return call_user_func_array(array($obj, $function_name), $arguments);

    }// end function __callStatic

    public function __destruct()
    {

        $class_property_array = get_object_vars($this);

        foreach ($class_property_array as $property_key => $property_value) {

            switch ($property_key) {
                case 'db_obj':
                    break;

                default:
                    unset($this->$property_key);
                    break;
            }

        }

    }// end function __destruct

}// end of class DataDao