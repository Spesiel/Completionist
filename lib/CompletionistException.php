<?php namespace Completionist;

class CompletionistException extends \Exception
{
    public function __construct($message)
    {
        error_log("=== An error occured: $message");
    }
}
