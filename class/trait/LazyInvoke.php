<?php
trait LazyInvoke
{

    public function __invoke($instance_data)
    {
        $this->__construct($instance_data);
        return $this;
    }// end function __invoke

}
