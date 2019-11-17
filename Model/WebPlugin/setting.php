<?php

namespace Model\WebPlugin;

class Model_Setting extends \Model
{
    public static function getSetting($user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('setting s');
        $obj->addAndWhere('user_id='.$user_id);

        $result = $obj->query(false);
        return $result[0];
    }
}