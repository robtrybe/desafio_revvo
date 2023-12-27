<?php

namespace Source\Services;

use Exception;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Source\Exceptions\DefaultException;
use Source\Models\Course;

class CourseService {

    public static function store(array $data) {
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

        $slideImageName = $courseModel->slug;
        $coverImageName =$courseModel->slug;
        $slideImagePath = self::createSlideImages($slideImageInfo['tmp_name'], $slideImageName);
        $coverImagePath = self::createCoverImages($coverImageInfo['tmp_name'], $coverImageName);

        $courseModel->slide_image = $slideImagePath;
        $courseModel->cover_image = $coverImagePath;
        $courseModel->description = $data->description;
        $courseModel->save();
    
        return true;
    }

    public static function update($data, $course) {
        $slideImageInfo = null;
        $coverImageInfo = null;

        if(!empty($_FILES['slide-image'])) $slideImageInfo = self::checkImageSlide();
        if(!empty($_FILES['cover-image'])) $coverImageInfo = self::checkImageCover();

        try{
            $imageData = (object) $course->validate($data);

            if ($slideImageInfo) {
                self::removeSlideImages($course->name);
                $course->slide_image = self::createSlideImages($slideImageInfo['tmp_name'], $imageData->name);
            }

            if ($coverImageInfo) {
                self::removeCoverImages($course->name);
                $course->cover_image = self::createCoverImages($coverImageInfo['tmp_name'], $imageData->name);
            }

            if(!$slideImageInfo) $course->slide_image = self::renameSlideImages($course->name, $imageData->name);
            if(!$coverImageInfo) $course->cover_image = self::renameCoverImages($course->name, $imageData->name);

            $course->name = $imageData->name;
            $course->slug = $imageData->slug;
            $course->description = $imageData->description;
            $course->save();
        }catch(DefaultException $e) {
            throw $e;
        }catch(Exception $e) {
            throw new DefaultException('Erro ao tentar atualizar curso', 400);
        }
    }

    /**
     * Deleta um curso especifico
     * @param Source\Models\Course Curso a ser removido
     * @return Retorna VERDADEIRO caso êxito na remoção ou lança uma exceção
     */
    public static function delete(Course $course): bool|DefaultException {
        try{
            self::removeCoverImages($course->name);
            self::removeSlideImages($course->name);
            $course->destroy();
            return true;
        }catch(Exception $e) {
            throw new DefaultException('Oops! Houve um erro ao tentar deletar curso', 403); 
        }
    }

    public static function show(int $id): Course|DefaultException {
        $courseModel = new Course();
        $course = $courseModel->findById($id);

        if(!$course) {
            throw new DefaultException('Curso não encontrado ou inexistente', 404);
        }

        return $course;
    }

    /**
     * Renomeia todas as imagens de slide de um curso com base no novo nome passado como parâmetro
     * @param string $oldName Nome antigo da imagem
     * @param string $newName Novo nome para a imagem
     * @return string Caminho da imagem a ser armazenada no banco
     */
    private static function renameSlideImages(string $oldName, string $newName, $outType = 'webp'): string {
        for($i = 0; $i < count(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH); $i++) {
            if(CONF_IMG_SLIDE_DEF_WIDTH === CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i]) {
                $oldImageName = str_slug($oldName).'-slide.'.$outType;
                $newImageName = str_slug($newName).'-slide.'.$outType;
                $relativePathImage = CONF_IMG_FOLDER.'/'.$newImageName;
                if(file_exists(CONF_IMG_UPLOAD_FOLDER_PATH.$oldImageName)){
                    rename(CONF_IMG_UPLOAD_FOLDER_PATH.$oldImageName, CONF_IMG_UPLOAD_FOLDER_PATH.$newImageName);
                }
            }else{
                $oldImageName = str_slug($oldName).'-slide-'.CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i].'.'.$outType;
                $newImageName = str_slug($newName).'-slide-'.CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i].'.'.$outType;
                if(file_exists(CONF_IMG_UPLOAD_FOLDER_PATH.$oldImageName)){
                    rename(CONF_IMG_UPLOAD_FOLDER_PATH.$oldImageName, CONF_IMG_UPLOAD_FOLDER_PATH.$newImageName);
                }
            }
        }

        return $relativePathImage;
    }
    /**
     * Renomeia todas as imagens de capa de um curso com base no novo nome passado como parâmetro
     * @param string $oldName Nome antigo da imagem
     * @param string $newName Novo nome para a imagem
     * @return string Caminho da imagem a ser armazenada no banco
     */
    private static function renameCoverImages(string $oldName, string $newName, $outType = 'webp'): string {
        for($i = 0; $i < count(CONF_IMG_COVER_RESOLUTIONS_WIDTH); $i++) {
            if(CONF_IMG_COVER_DEF_WIDTH === CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i]) {
                $oldImageName = str_slug($oldName).'-cover.'.$outType;
                $newImageName = str_slug($newName).'-cover.'.$outType;
                $relativePathImage = CONF_IMG_FOLDER.'/'.$newImageName;
            }else{
                $oldImageName = str_slug($oldName).'-cover-'.CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i].'.'.$outType;
                $newImageName = str_slug($newName).'-cover-'.CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i].'.'.$outType;
            }

            if(file_exists(CONF_IMG_UPLOAD_FOLDER_PATH.$oldImageName)) {
                rename(CONF_IMG_UPLOAD_FOLDER_PATH.$oldImageName, CONF_IMG_UPLOAD_FOLDER_PATH.$newImageName);
            }
        }
        return $relativePathImage;
    }

    /**
     * Cria imagens de slide com diferentes resoluções
     * @param string $imagePath Caminho da imagem recebido atraves da constante $_FILES 
     * @param string $imagemName Nome para a imagem
     * @param string $outType Formato da imagem de saida. O padrao é webp
     * @return string Caminho da nova imagem base a ser armazenada no banco
     */
    private static function createSlideImages(string $imagePath, string $imageName, $outType = 'webp'): string {
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager::imagick()->read($imagePath);
        $imageName = str_slug($imageName).'-slide';

        for($i =0 ; $i < count(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH); $i++){
            if(CONF_IMG_SLIDE_DEF_WIDTH === CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i]) {
                $image->resize(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i], CONF_IMG_SLIDE_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'.'.$outType);
            }else{
                $image->resize(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i], CONF_IMG_SLIDE_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'-'.CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i].'.'.$outType);
            }
        }

        return CONF_IMG_FOLDER.'/'.$imageName.'.'.$outType;
    }

    /**
     * Checa se o tamanho da imagem de slide esta de acordo com as configurações pré-definidas
     * @param string $imagePath Caminho da imagem a ser verificada
     * @return bool|DefaultException Retorna true caso o tamanho da imagem seja valida ou lança uma Exceção
     */
    private static function checkSlideImageSize(string $imagePath):bool|DefaultException {
        $imageInfo = getimagesize($imagePath);
        if($imageInfo[0] != CONF_IMG_SLIDE_DEF_WIDTH || $imageInfo[1] != CONF_IMG_SLIDE_DEF_HEIGHT){
            $message = 'O tamanho da resolução da imagem de slide deve ser de '.CONF_IMG_SLIDE_DEF_WIDTH.' x ';
            $message .= CONF_IMG_SLIDE_DEF_HEIGHT;
            throw new DefaultException($message, 400);
        }

        return true;
    }

    /**
     * Checa se o tamanho da imagem de capa esta de acordo com as configurações pré-definidas
     * @param string $imagePath Caminho da imagem a ser verificada
     * @return bool|DefaultException Retorna true caso o tamanho da imagem seja valida ou lança uma Exceção
     */
    private static function checkCoverImageSize(string $imagePath): bool|DefaultException {
        $imageInfo = getimagesize($imagePath);
        if($imageInfo[0] != CONF_IMG_COVER_DEF_WIDTH || $imageInfo[1] != CONF_IMG_COVER_DEF_HEIGHT){
            $message = 'O tamanho da resolução da imagem de capa deve ser de '.CONF_IMG_COVER_DEF_WIDTH.' x ';
            $message .= CONF_IMG_COVER_DEF_HEIGHT;
            throw new DefaultException($message, 400);
        }

        return true;
    }

    /**
     * Cria imagens de capa com diferentes resoluções
     * @param string $imagePath Caminho da imagem recebido atraves da constante $_FILES 
     * @param string $imagemName Nome para a imagem
     * @param string $outType Formato da imagem de saida. O padrao é webp
     * @return string Caminho da nova imagem base a ser armazenada no banco
     */
    private static function createCoverImages(string $imagePath, string $imageName, $outType = 'webp'): string {
        $imageManager = new ImageManager(new Driver());
        $image = $imageManager::imagick()->read($imagePath);
        $imageName = str_slug($imageName). '-cover';

        for($i =0 ; $i < count(CONF_IMG_COVER_RESOLUTIONS_WIDTH); $i++){
            if(CONF_IMG_COVER_DEF_WIDTH === CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i]) {
                $image->resize(CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i], CONF_IMG_COVER_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'.'.$outType);
            }else{
                $image->resize(CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i], CONF_IMG_COVER_RESOLUTIONS_HEIGHT[$i]);
                $image->toWebp()->save(CONF_IMG_UPLOAD_FOLDER_PATH.$imageName.'-'.CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i].'.'.$outType);
            }
        }

        return CONF_IMG_FOLDER.'/'.$imageName.'.'.$outType;
    }

    /**
     * Verifica se a imagem de slide existe e se é uma imagem válida através do mimetype da mesma
     * @return array|DefaultException Retorna um array com as informações da imagem ou lança uma exceção
     */
    private static function checkImageSlide(): array|DefaultException {
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

     /**
     * Verifica se a imagem de capa existe e se é uma imagem válida através do mimetype da mesma
     * @return array|DefaultException Retorna um array com as informações da imagem ou lança uma exceção
     */
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

    /**
     * Remove todas as imagens de slide de um curso com base no nome passada como parâmetro
     * @param string $imageName Nome da imagem
     * @param string $outType Formato de saída (Extenção de saída da imagem) 
     */
    private static function removeSlideImages(string $imageName, $outType = 'webp') {
        for($i = 0; $i < count(CONF_IMG_SLIDE_RESOLUTIONS_WIDTH); $i++) {
            if(CONF_IMG_SLIDE_DEF_WIDTH === CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i]) {
                $newName = str_slug($imageName.'-slide.'.$outType);
                self::remove($newName);
            }else{
                $newName = str_slug($imageName.'-slide-'.CONF_IMG_SLIDE_RESOLUTIONS_WIDTH[$i].'.'.$outType);
                self::remove($newName);
            }
        }
    }

     /**
     * Remove todas as imagens de capa de um curso com base no nome passada como parâmetro
     * @param string $imageName Nome da imagem
     * @param string $outType Formato de saída (Extenção de saída da imagem) 
     */
    private static function removeCoverImages(string $imageName, $outType = 'webp') {
        for($i = 0; $i < count(CONF_IMG_COVER_RESOLUTIONS_WIDTH); $i++) {
            if(CONF_IMG_COVER_DEF_WIDTH === CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i]) {
                $newName = str_slug($imageName.'-cover.'.$outType);
                self::remove($newName);
            }else{
                $newName = str_slug($imageName.'-cover-'.CONF_IMG_COVER_RESOLUTIONS_WIDTH[$i].'.'.$outType);
                self::remove($newName);
            }
        }
    }

    /**
     * Remove uma imagem com base no nome passado como parâmetro
     * @param string $imageName Nome da imagem a ser removida
     * @return void Não retorna nada 
     */
    private static function remove($imageName): void {
        $filePath = CONF_IMG_UPLOAD_FOLDER_PATH.$imageName;
        if(file_exists($filePath)){
            unlink($filePath);
        }
    }
}