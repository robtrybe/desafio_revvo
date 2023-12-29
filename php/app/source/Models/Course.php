<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;
use Source\Exceptions\DefaultException;
use Respect\Validation\Validator as v;

class Course extends DataLayer{
    public function __construct()
    {
        parent::__construct("courses", ['name', 'slug', 'slide_image', 'cover_image']);
    }

    function validate($data): array|Exception {
        if(empty($data['name']) || empty($data['description'])) {
            throw new DefaultException('Todos os campos devem ser informados', 400);
        }

        if(!v::regex('/^[a-zà-ú\s]{1,100}$/i')->validate($data['name'])) {
            throw new DefaultException('O nome informado é inválido', 400);
        }

        $data['slug'] = trim(str_slug($data['name']));
        $data['description'] = filter_var($data['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        return $data;
    }
}