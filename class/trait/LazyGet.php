<?php
trait LazyGet
{

    public function __get($key)
    {

        $method = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

        if (in_array($key, array('db_obj', 'dao_obj'))) {
            return null;
        } else if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            if ($key == 'id' || (isset($this->$key) && $this->$key !== false)) {
                return $this->$key;
            } else {
                $message = get_class($this).': '.
                           'data of the attribute "'.$key.'" is not defined or attribute not exists.';
                throw new RuntimeException($message);
            }
        }

    }// end function __get

}
