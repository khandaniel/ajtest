<?php
/**
 * Created by PhpStorm.
 * User: Samir
 * Date: 10.02.2018
 * Time: 18:02
 */

require_once "../app/Model.php";
require_once "../app/Table.php";

class TableController
{
    public function getPlaces($type, $reg_id = null) // Function accepts string with type of places expected to be received and region's id
    {
        $table = new Table();
        switch ($type) { // Depending on type of place
            case 'region':
                return $table->getRegions(); // it requests from Table model to get this type of places ...
            case 'city':
                return $table->getCities($reg_id);
            case 'area':
                return $table->getAreas($reg_id);
        }
    }

    public function getTerritoryName($id) // This function is needed to get the Name of Territory By Id (ter_id or reg_id)
        // though I could probably use foreign key or inner join... But it would make me more and more problems for the sake of different table's
        //     charsets (utf8_unicode_ci or utf8_generic_ci) and other stuff
    {
        $table = new Table();
        return $table->getTerritoryNameById($id);
    }
}