<?php
class UserDao extends DataDao
{

    /**
     * inherited variables:
     *
     * protected $db_obj;
     * protected $table_name;
     * protected static $default_params = array(
     *     'field'  => '*',
     *     'where'  => '',
     *     'param'  => array(),
     *     'group'  => '',
     *     'order'  => '',
     *     'offset' => 0,
     *     'length' => 0,
     *     'join'   => array(
     *         0 => array(
     *             'table' => '',
     *             'on'    => ''
     *         )
     *     )
     * );
     */

    /**
     * inherited functions:
     *
     * puvlic function insert() {}
     * public function select() {}
     * public function update() {}
     * public function delete() {}
     * protected function appendIsDeleted() {}
     */

    public function getUserCondition($is_deleted = '')
    {
        $query_params = array(
            'field' => 'id'
        );
        return $this->appendIsDeleted($query_params, $is_deleted);
    }// end function getUserCondition

}// end class UserDao
