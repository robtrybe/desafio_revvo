<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class CourseController extends Controller {
    private $imageManager;

    function __construct() {
        parent::__construct();
        $this->imageManager = new ImageManager(new Driver());
    }
    
    public function index(?array $data) {
        $data = (object) $data;
        if(!empty($data->csrf)){
            if(!$_FILES || empty($_FILES['cover-image']) || empty($_FILES['slide-image'])){
                echo json_encode(['message' => 'As imagens de capa e slide são obrigatórias']);
                return;
            }
            
            $coverImageFile = $_FILES['cover-image'];
            $slideImageFile = $_FILES['slide-image'];
            

            $isValidCoverType = in_array($coverImageFile['type'], CONF_IMG_ALLOW_TYPES);
            $isValidSlideType = in_array($slideImageFile['type'], CONF_IMG_ALLOW_TYPES);

            if(!$isValidCoverType || !$isValidSlideType) {
                echo json_encode(['message' => 'Imagem de capa ou slide inválida']);
                return;
            }
            
            $slideImageName = substr($slideImageFile['name'], 0, strrpos( $slideImageFile['name'], '.')).'-slide';
            echo $this->createSlideImages($slideImageFile['tmp_name'], $slideImageName);
            return;
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