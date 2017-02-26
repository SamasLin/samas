<?php
trait LazySet
{

    public function __set($key, $value)
    {

        $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

        if (in_array($key, array('db_obj', 'dao_obj'))) {
            // do nothing
        } else if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            $this->$key = $value;
        }

    }// end function __set

}
