<?php
/**
 * Created by PhpStorm.
 * User: Samir
 * Date: 10.02.2018
 * Time: 17:54
 */


require_once "../app/Model.php";
require_once "../app/User.php";


class UserController
{

    public function emailCheck($email) { // function requests from User model if there's already user with such email in database.
        $user = new User();
        return $user->findUser($email); // This function returns array or an empty array
    }

    public function addUser($data) // Key function that adds User's data into DB
    {
        $newUser = new User();
        if(!$newUser->exists($data['email'])) { // if it not exists yet
            $newUser->save($data);
            return true;
        } else {
            return false; // and returns boolean for success alert
        }
    }

}