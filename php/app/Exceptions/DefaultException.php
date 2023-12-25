<?php

namespace Source\Exceptions;
use \Exception;

class DefaultException extends Exception {
    private $type;

    function __construct(string $message, int $code, $type = 'error')
    {
        $this->message = $message;    
        $this->code = $code;
        $this->type = $type;
    }

    public function getType(string $type) {
        return $this->type;
    }
} 