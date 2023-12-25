<?php

namespace Source\Core;

use Source\Core\View;
use Source\Support\Message;

abstract class Controller {
    protected View $view;
    protected Message $message;

    function __construct()
    {
        $this->view = new View();
        $this->message = new Message();    
    }
}