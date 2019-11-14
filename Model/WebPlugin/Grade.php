<?php

namespace Model\WebPlugin;

class Model_Grade extends \Model
{
    public static function getGradeByGrade($id = 0){
        if(!$id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('id='.$id);
        return $obj->query(false);
    }
}