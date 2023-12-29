<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Models\Course;

class AdminController extends Controller {

    public function dash() {
        $courses = (new Course())->find()->fetch(true);

        echo $this->view->render('admin/dash', ['title'=> 'Dashboard','courses' => $courses]);
    }
}