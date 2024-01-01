<?php 

namespace Source\Controllers;

use Source\Core\Controller;

class LoginController extends Controller {

    public function login(?array $data): void {
        $data = (object) $data;
        
        if(!empty($data->csrf)) {
            echo json_encode(['message' => 'Tentou fazer login?']);
            return;
        }

        echo $this->view->render('site/login', ['title' => 'Faça login']);
    }
}