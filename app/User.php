<?php
/**
 * Created by PhpStorm.
 * User: Samir
 * Date: 10.02.2018
 * Time: 1:59
 */

class User extends Model
{
    public function findUser($email) // Returns array or an empty array if user with such email is not found
    {
        return $this->fetchTable("SELECT * FROM `users` WHERE email = '{$email}'");
    }

    public function exists($email) // Returns boolean if user exists or not
    {
        $user = $this->query("SELECT email FROM users WHERE email = '{$email}'"); // Query only checks email column.
        if ($user->fetch_assoc()) {
            return true;
        } else {
            return false;
        }
    }

    public function save($data)
    {
        $query = "INSERT INTO `users` (name, email, region, city, area) VALUES ('" .
            htmlspecialchars($data['name']) . "', '" .
            filter_var($data['email'], FILTER_VALIDATE_EMAIL) . "', '" . // returns empty string if not valid email.
            htmlspecialchars($data['theregion']) . "', '" .
            htmlspecialchars($data['city']) . "', '" .
            htmlspecialchars($data['area']) . "')";
        return $this->query($query);
    }
}