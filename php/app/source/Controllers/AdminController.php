<?php

namespace Source\Controllers;

use Source\Core\Controller;

class AdminController extends Controller {
    public function dash() {
        echo $this->view->render('admin/dash', ['title' => 'Dashboard']);
    }
}