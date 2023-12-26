<?php

namespace Source\Services;

use Exception;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Source\Exceptions\DefaultException;
use Source\Models\Course;

class CourseService {

    public static function create(array $data) {
        $courseModel = new Course();

        try{
            $data = (object) $courseModel->validate($data);
            if($courseModel->find("slug = :slug", "slug={$data->slug}")->fetch()) {
                throw new DefaultException('Já existe um curso cadastrado com esse nome', 409);
            }

            $courseModel->name = $data->name;
            $courseModel->slug = $data->slug;
        }catch(DefaultException $e) { 
            throw $e;
        }catch(Exception $e) {
            throw new DefaultException('Não foi possível cadastrar curso', 400);
        }

        $slideImageInfo = self::checkImageSlide();
        $coverImageInfo = self::checkImageCover();

        $slideImageName = substr($slideImageInfo['name'], 0, strrpos( $slideImageInfo['name'], '.')).'-slide';
        $coverImageName = substr($coverImageInfo['name'], 0, strrpos( $coverImageInfo['name'], '.')).'-cover';
        $slideImagePath = self::createSlideImages($slideImageInfo['tmp_name'], $slideImageName);
        $coverImagePath = self::createCoverImages($coverImageInfo['tmp_name'], $coverImageName);

        $courseModel->slide_image = $slideImagePath;
        $courseModel->cover_image = $coverImagePath;
        $courseModel->description = $data->description;
        $courseModel->save();
    
        return true;
    }

    public static function update() {
        
    }

    private static function createSlideImages(string $imagePath, string $imageName, $outType = 'webp'): string {
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager::imagick()->read($imagePath);

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

    private static function checkSlideImageSize(string $imagePath) {
        $imageInfo = getimagesize($imagePath);
        if($imageInfo[0] != CONF_IMG_SLIDE_DEF_WIDTH || $imageInfo[1] != CONF_IMG_SLIDE_DEF_HEIGHT){
            $message = 'O tamanho da resolução da imagem de slide deve ser de '.CONF_IMG_SLIDE_DEF_WIDTH.' x ';
            $message .= CONF_IMG_SLIDE_DEF_HEIGHT;
            throw new DefaultException($message, 400);
        }

        return true;
    }

    private static function checkCoverImageSize(string $imagePath) {
        $imageInfo = getimagesize($imagePath);
        if($imageInfo[0] != CONF_IMG_COVER_DEF_WIDTH || $imageInfo[1] != CONF_IMG_COVER_DEF_HEIGHT){
            $message = 'O tamanho da resolução da imagem de capa deve ser de '.CONF_IMG_COVER_DEF_WIDTH.' x ';
            $message .= CONF_IMG_COVER_DEF_HEIGHT;
            throw new DefaultException($message, 400);
        }

        return true;
    }

    private static function createCoverImages(string $imagePath, string $imageName, $outType = 'webp'): string {
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager::imagick()->read($imagePath);

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

    private static function checkImageSlide(): array|Exception {
        if($_FILES && !empty($_FILES['slide-image']) && empty($_FILES['slide-image']['tmp_name'])) {
            throw new DefaultException('Imagem de slide inválida', 400);
        }
        
        if(!$_FILES || empty($_FILES['slide-image'])) {
            throw new DefaultException('A Imagem de slide é obrigatória', 400);
        }
        
        self::checkSlideImageSize($_FILES['slide-image']['tmp_name']);

        $slideImageFile = $_FILES['slide-image'];
        $isValidSlideType = in_array($slideImageFile['type'], CONF_IMG_ALLOW_TYPES);

        if(!$isValidSlideType) {
            throw new DefaultException('Imagem de capa ou slide inválida', 400);
        }
        
        return $_FILES['slide-image'];
    }

    private static function checkImageCover() {
        if($_FILES && !empty($_FILES['cover-image']) && empty($_FILES['cover-image']['tmp_name'])) {
            throw new DefaultException('Imagem de capa inválida', 400);
        }
        
        if(!$_FILES || empty($_FILES['cover-image'])){
            throw new DefaultException('A Imagem de capa é obrigatória', 400);
        }

        self::checkCoverImageSize($_FILES['cover-image']['tmp_name']);

        $coverImageFile = $_FILES['cover-image'];
        $isValidCoverType = in_array($coverImageFile['type'], CONF_IMG_ALLOW_TYPES);

        if(!$isValidCoverType) throw new DefaultException('Imagem de capa inválida', 400); 
        return $_FILES['cover-image'];
    }
}