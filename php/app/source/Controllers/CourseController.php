<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Source\Exceptions\DefaultException;
use Source\Services\CourseService;
use Source\Models\Course as courseModel;

class CourseController extends Controller {
    private $imageManager;

    function __construct() {
        parent::__construct();
        $this->imageManager = new ImageManager(new Driver());
    }
    
    public function index(?array $data) {
        if(!empty($data['csrf'])) {
            try{
                CourseService::create($data);
                $this->message->success('Curso cadastrado com sucesso!')->flash();
                redirect('/course');
                return;
            }catch(DefaultException $e) {
                $message = $this->message->setType($e->getType())->setMessage($e->getMessage())->render();
                echo json_encode(['message' => $message]);
                return;
            }
        }
        echo $this->view->render('site/course/register', ['title' => 'Novo Curso']);
    }

    public function update(array $data) {
        $id = filter_var($data['id'], FILTER_VALIDATE_INT, array("options" => array("min_range" => 1, "max_range" => 1000)));
  
        if(!$id) { 
            echo json_encode(['redirect' => url('/oops/404')]);
            return;
        } 
        
        $course = (new courseModel())->findById($id);
        if(!$course) {
            echo json_encode(['redirect' => url('/oops/404')]);
            return;
        } 
      
        if(!empty($data['csrf'])) {
            try{
                CourseService::update($data, $course);
                echo json_encode(['message' => 'Curso Atualizado com Sucesso']);
                return;
            }catch(DefaultException $e) {
                $message = $this->message->setType($e->getType())->setMessage($e->getMessage())->render();
                echo json_encode(['message' => $message]);
                return;
            }
            
        }
    
        echo $this->view->render('site/course/update', ['title' => 'Atualizar Curso', 'course' => $course]);
    }

    private function createSlideImages(string $imagePath, string $imageName, $outType = 'webp'): string {
        $image = $this->imageManager::imagick()->read($imagePath);

        for($i =0 ; $i < count(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH); $i++){

            if(CONF_IMG_SLIDE_DEF_WIDTH === CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i]) {
                $image->resize(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i], CONF_IMG_SLIDE_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'.'.'webp');
            }else{
                $image->resize(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i], CONF_IMG_SLIDE_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'-'.CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i].'.'.$outType);
            }
        }

        return CONF_IMG_FOLDER.'/'.$imageName.'.'.$outType;
    }

    private function createCoverImages(string $imagePath, string $imageName, $outType = 'webp'): string {
        $image = $this->imageManager::imagick()->read($imagePath);

        for($i =0 ; $i < count(CONF_IMG_COVER_RESOLUTIONS_WIDTH); $i++){

            if(CONF_IMG_COVER_DEF_WIDTH === CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i]) {
                $image->resize(CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i], CONF_IMG_COVER_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'.'.'webp');
            }else{
                $image->resize(CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i], CONF_IMG_COVER_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'-'.CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i].'.'.$outType);
            }
        }

        return CONF_IMG_FOLDER.'/'.$imageName.'.'.$outType;
    }
}