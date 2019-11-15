<?php

namespace Model\WebPlugin;

class Model_Member extends \Model
{
    public static function getMemberByUser($user_user_id = 0){
        if(!$user_user_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('member s');
        $obj->addAndWhere('user_user_id='.$user_user_id);
        return $obj->query(false);
    }

    public static function getLowerListAndCount($user_id = 0){
        if(!$user_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('member s');
        $obj->addAndWhere('higher_id='.$user_id);

        $record = $obj->query(false);

        $count = $obj->count();

        return array('record'=>$record,'count'=>$count);
    }

}