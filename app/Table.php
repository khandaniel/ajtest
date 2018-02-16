<?php
/**
 * Created by PhpStorm.
 * User: Samir
 * Date: 10.02.2018
 * Time: 17:47
 */


class Table extends Model
{
    public function getRegions()  // Returns array with regions and its required id's
    {
        return $this->fetchTable("SELECT ter_id, ter_name, reg_id FROM t_koatuu_tree WHERE ter_type_id = 0");
    }

    public function getCities($reg_id)
    {
        return $this->fetchTable("SELECT ter_id, ter_name FROM t_koatuu_tree WHERE (ter_type_id = 1 OR ter_type_id = 2) AND (ter_level = 2 OR ter_level = 3) AND reg_id = {$reg_id}");
    }

    public function getAreas($reg_id) // Must probably accept ter_level and mask and ter_id of City ^ to get
    {
        return $this->fetchTable("SELECT ter_id, ter_name FROM t_koatuu_tree WHERE reg_id = {$reg_id} AND (ter_type_id = 2 OR ter_type_id = 3)");
    }


    public function getTerritoryNameById($ter_id) // Only returns string with name of territory with given id (ter_id or reg_id)
    {
        if ($ter_id) {
            $name = $this->fetchTable("SELECT ter_address FROM t_koatuu_tree WHERE ter_id = '{$ter_id}'");
        }
        return $name[0]['ter_address'];

    }
}