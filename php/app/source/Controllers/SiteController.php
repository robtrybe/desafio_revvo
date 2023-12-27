<?php

namespace Source\Controllers;

use Source\Core\Controller;

class SiteController extends Controller {
    public function home() {
        echo $this->view->render('site/home', ['title' => 'Página Principal']);
    }
}