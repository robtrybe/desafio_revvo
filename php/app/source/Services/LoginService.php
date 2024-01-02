<?php

namespace Source\Services;

use Source\Exceptions\DefaultException;
use Source\Models\User;
use stdClass;

class LoginService {

    public static function login(string $email, string $password): User|DefaultException {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if(empty($email) || empty($password)) new DefaultException('Todos os campos devem ser informados', 400);

        if(!$email) {
            throw new DefaultException('Usuário ou Senha Inválido', 400);
        }else if(mb_strlen($password) < 6 || mb_strlen($password) > 12) {
            throw new DefaultException('Usuário ou Senha Inválido', 400);
        }

        $user = (new User())->find(
            'email = :email', "email={$email}")->fetch();

        if(!$user) {
            throw new DefaultException('Usuário ou Senha Inválido', 400);
        }

        if(!password_verify($password, $user->password)){
            throw new DefaultException('Usuário ou Senha Inválido', 400);
        }

        $userSession = new stdClass();
        $userSession->id = $user->id;
        $userSession->first_name = $user->first_name;
        $userSession->last_name = $user->last_name;
        $userSession->email = $user->email;

        session()->set('user', $userSession);
        return $user;
    }
}