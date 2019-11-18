<?php

namespace Model\WebPlugin;

class Model_User extends \Model
{
    public static function getUserById($id = 0){
        if(!$id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('user_user s');
        $obj->addAndWhere('id='.$id);
        return $obj->query(false);
    }
}