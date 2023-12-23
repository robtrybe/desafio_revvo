<?php 

namespace Source\Support;

use Source\Core\Session;

class Message {
    private $message;
    private $type;

    public function __toString()
    {
        return $this->render();
    }

    public function success(string $message): Message {
        $this->message = $this->filter($message);
        $this->type = CONF_MESSAGE_SUCCESS;
        return $this;
    }

    public function info(string $message): Message {
        $this->message = $this->filter($message);
        $this->type = CONF_MESSAGE_INFO;
        return $this;
    }

    public function warning(string $message): Message {
        $this->message = $this->filter($message);
        $this->type = CONF_MESSAGE_WARNING;
        return $this;
    }

    public function error(string $message): Message {
        $this->message = $this->filter($message);
        $this->type = CONF_MESSAGE_ERROR;
        return $this;
    }

    private function filter(string $message): string {
        return filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function render(): string {
        return '<div class="'.CONF_MESSAGE_CLASS.' '.$this->type.'">'.$this->message.'</div>';
    }

    public function json(): string {
        return json_encode(['error' => $this->message]);
    }

    public function flash(): void {
        (new Session())->set('flash', $this);
    }
}