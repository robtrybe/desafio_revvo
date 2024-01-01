<?php 

namespace Source\Controllers;

use Source\Services\LoginService;
use Source\Core\Controller;
use Source\Exceptions\DefaultException;

class LoginController extends Controller {
    public function login(?array $data): void {
        if(session()->user) {
            $method = $_SERVER['REQUEST_METHOD'];
            if($method === 'POST') {
                echo json_encode(['redirect' => url('/')]);
                return;
            }else{
                redirect('/');
                return;
            }
        }

        $data = (object) $data;

        if(!empty($data->csrf)) {
            try{
                $user = LoginService::login($data->email, $data->password);
                $this->message->success("Seja bem-vindo {$user->first_name}!")->flash();
                echo json_encode(["redirect" => url("/")]);
                return;
            }catch(DefaultException $e) {
                $message = $this->message->error($e->getMessage())->setType($e->getType())->render();
                echo json_encode(["message" => $message]);
                return;
            }
        }

        echo $this->view->render('site/login', ['title' => 'Faça login']);
    }

    public function logout()  {
        $user = session()->user;
        session()->destroy();

        $this->message->success("É muito bom ter você conosco {$user->first_name}! Volte Sempre!")->flash();
        redirect('/');
    }
}