<?php

namespace Source\Services;

use Exception;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Source\Exceptions\DefaultException;

class CourseService {
    private $imageManager;

    public static function create(object $data) {
        $slideImageInfo = self::checkImageSlide();
        $coverImageInfo = self::checkImageCover();

        $slideImageName = substr($slideImageInfo['name'], 0, strrpos( $slideImageInfo['name'], '.')).'-slide';
        $coverImageName = substr($coverImageInfo['name'], 0, strrpos( $coverImageInfo['name'], '.')).'-cover';
        self::createSlideImages($slideImageInfo['tmp_name'], $slideImageName);
        self::createCoverImages($coverImageInfo['tmp_name'], $coverImageName);
        return;
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

        $coverImageFile = $_FILES['cover-image'];
        $isValidCoverType = in_array($coverImageFile['type'], CONF_IMG_ALLOW_TYPES);

        if(!$isValidCoverType) throw new DefaultException('Imagem de capa inválida', 400); 
        return $_FILES['cover-image'];
    }
}