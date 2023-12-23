<?php

namespace Source\Core;

use League\Plates\Engine;

class View {
    private $engine;

    function __construct(string $path = CONF_VIEW_PATH, string $ext = CONF_VIEW_EXT)
    {
        $this->engine = new Engine($path, $ext);
    }

    function render(string $view, array $data): string {
        return $this->engine->render($view, $data);
    }

    function engine(): Engine {
        return $this->engine;
    }
}