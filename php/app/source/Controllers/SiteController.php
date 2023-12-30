<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Models\Course;

class SiteController extends Controller {
    public function home() {

        $course = (new Course());
        $courseSlides = $course->find()->limit(3)->fetch(true);

        echo $this->view->render('site/home', [
            'title' => 'Página Principal', 
            'courseSlides' => $courseSlides
        ]);
    }
}