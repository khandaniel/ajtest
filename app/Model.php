<?php
/**
 * Created by PhpStorm.
 * User: Samir
 * Date: 10.02.2018
 * Time: 0:12
 */

class Model
{

    public function __construct() // Connects to DB on creating new instance of Model
    {
        return $this->connect();
    }

    public function connect() // Returns $link with connection to DB
    {
        $dbsecret = json_decode(file_get_contents('../secret.json')); // Retrieving secrets from json-file
        $link = new mysqli($dbsecret->host, $dbsecret->user, $dbsecret->password, $dbsecret->db);
        $link->set_charset('utf8');
        return $link;
    }

    public function query($query) // Returns result of query to DB
    {
        return $this->connect()->query($query);
    }


    public function fetchTable($query) // Returns array from DB
    {
        $data = $this->connect()->query($query);
        $array = [];
        while ($row = $data->fetch_assoc()) {
            $array[] = $row;
        }
        return $array;
    }
}
