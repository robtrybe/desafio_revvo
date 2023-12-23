<?php

namespace Source\Core;

use Source\Support\Message;

/**
 * Classe para manipulação de sessões
 */
class Session {
    function __construct()
    {
        if(!session_id()){
            session_start();
        }
    }

    /**
     * @param string $name Nome do índice a ser retornado variavel $_SESSION
     * @return mixed
     */
    public function __get($name) {
        if(!empty($_SESSION[$name])){
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * Verifica se o índice da $_SESSION está setado
     * @param string $name Nome do índice a ser verificado
     * @return bool Retorna verdadeiro ou falso
     */
    public function __isset($name): bool {
        return $this->has($name);
    }

    /**
     * Configura a variavel $_SESSION com índice e valor especificado
     * @param string $key Índice a ser configurado
     * @param mixed $value Valor do índice a ser configurado
     * @return \Source\Core\Session Retorna o objeto Session 
     */
    public function set(string $key, mixed $value): Session {
        $_SESSION[$key] = (is_array($value) ? (object) $value : $value);
        return $this; 
    }

    public function all(): ?object {
        return (object) $_SESSION;
    }

    public function unset(string $key): Session {
        unset($_SESSION[$key]);
        return $this;
    }

    public function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public function regenerate(): Session {
        session_regenerate_id(true);
        return $this;
    }

    public function destroy(): Session {
        session_destroy();
        return $this;
    }

    public function flash(): ?Message {
        if($this->has('flash')){
            $flash = $this->flash;
            $this->unset('flash');
            return $flash;
        }
        return null;
    }

    public function csrf(): void {
        $_SESSION['csrf_token'] = base64_encode(random_bytes(20));
    }
}