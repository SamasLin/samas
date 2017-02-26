<?php
trait ReturnName
{

    public function __toString()
    {
        if (method_exists($this, 'getName')) {
            return $this->getName();
        } else {
            if (isset($this->name) && $this->name !== false) {
                return $this->name;
            } else {
                return 'UNDEFINED';
            }
        }
    }// end function __toString

}
