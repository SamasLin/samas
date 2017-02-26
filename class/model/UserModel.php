<?php
class UserModel extends DataModel
{

    /**
     * used trait:
     *
     * LazyGet, LazySet, LazyInvoke, ReturnName
     */

    /**
     * inherited variables:
     *
     * protected $dao_obj;
     * protected $id;
     * protected $is_deleted;
     * protected $create_time;
     * protected $modify_time;
     * protected $delete_time;
     */
    protected $account;
    protected $csrf_token;
    protected $email;
    protected $name;
    protected $password;

    /**
     * inherited functions:
     *
     * public function set() {}
     * public function save() {}
     * public function destroy($type = ['mark' | 'delete']) {}
     * public function recover() {}
     * public function reset() {}
     */

}// end class UserModel
