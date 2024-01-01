<?php 

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer{
    function __construct()
    {   
        parent::__construct("users", ['first_name', 'last_name', 'email', 'password']);
    }
}