<?php namespace Completionist;

class Result extends \stdclass
{
    public function __construct()
    {
        $this->errors = array();
        $this->messages = array();
        $this->result = array();

        $args = func_get_args();
        $argsCount = func_num_args();
        if (method_exists($this, $function = '__construct'.$argsCount)) {
            call_user_func_array(array($this,$function), $args);
        }
    }

    public function __construct1($result)
    {
        $this->result = $result;
    }
}
