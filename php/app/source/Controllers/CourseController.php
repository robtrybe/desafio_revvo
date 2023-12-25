<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Source\Exceptions\DefaultException;
use Source\Services\CourseService;

class CourseController extends Controller {
    private $imageManager;

    function __construct() {
        parent::__construct();
        $this->imageManager = new ImageManager(new Driver());
    }
    
    public function index(?array $data) {
        $data = (object) $data;

        if(!empty($data->csrf)) { 
            try{
                CourseService::create($data);
            }catch(DefaultException $e) {
                $message = $this->message->setType($e->getType())->setMessage($e->getMessage())->render();
                echo json_encode(['message' => $message]);
                return;
            }
        }
        echo $this->view->render('site/course/register', ['title' => 'Novo Curso']);
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