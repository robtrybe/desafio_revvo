<?php

namespace Source\Core;
use Source\Core\View;
use Source\Support\Message;

abstract class Controller {
    private View $view;
    private Message $message;

    function __construct()
    {
        $this->view = new View();
        $this->message = new Message();    
    }
}