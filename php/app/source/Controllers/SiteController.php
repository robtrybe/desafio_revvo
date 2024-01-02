<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Models\Course;
use Source\Models\User;

class SiteController extends Controller {
    public function home() {
        $userModel = new User();
        $userId = session()->user ? session()->user->id : null;
        $courses = [];

        if($userId){
            $courses = $userModel->findById($userId)->getCourses();
        }else{
            $courses = (new Course())->find()->fetch(true);
        }
        

        $course = (new Course());
        $courseSlides = $course->find()->limit(3)->fetch(true);

        echo $this->view->render('site/home', [
            'title' => 'Página Principal', 
            'courseSlides' => $courseSlides,
            'courses' => $courses
        ]);
    }
}