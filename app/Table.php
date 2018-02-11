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
        return $this->fetchTable("SELECT ter_id, ter_name FROM t_koatuu_tree WHERE ter_type_id = 1 AND reg_id = {$reg_id}");
    }

    public function getAreas($reg_id)
    {
        return $this->fetchTable("SELECT ter_id, ter_name FROM t_koatuu_tree WHERE reg_id = {$reg_id} AND (ter_type_id = 2 OR ter_type_id = 3)");
    }

    public function getTerritoryNameById($ter_id = null, $reg_id = null) // Only returns string with name of territory with given id (ter_id or reg_id)
    {
        if ($ter_id) {
            $name = $this->query("SELECT ter_name FROM t_koatuu_tree WHERE ter_id = '{$ter_id}'");
        } elseif ($reg_id) {
            $name = $this->query("SELECT ter_name FROM t_koatuu_tree WHERE reg_id = '{$reg_id}'");
        }
        return $name->fetch_assoc()['ter_name'];

    }
}