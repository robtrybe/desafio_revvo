<?php 

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use PDO;
use Source\Core\DBConnect;

class User extends DataLayer{
    function __construct()
    {   
        parent::__construct("users", ['first_name', 'last_name', 'email', 'password']);
    }

    /**
     * Retorna todos os cursos adquiridos pelo usuário
     * @return array Array de Cursos
     */
    public function getCourses($limit = 4): array {
        $pdo = DBConnect::getInstance();
        $sql = 'select DISTINCT courses.* from users_courses';
        $sql .= " join courses on courses.id=users_courses.course_id where user_id={$this->id} LIMIT {$limit}";

        $result = $pdo->query($sql)->fetchAll(PDO::FETCH_CLASS, Course::class);
        return $result;
    }
}