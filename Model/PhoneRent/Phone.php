<?php

namespace Model\PhoneRent;

class Model_Phone extends \Model
{
    public static function getPhoneList($user_id){
        if(!$user_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('phone s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('is_del=0');
        $obj->addOrderBy('create_time','desc');
        return $obj->query(false);
    }

    public static function checkPhone($user_id,$phone_model){
        if(!$user_id || !$phone_model)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('phone s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('phone_model="'.$phone_model.'"');
        $obj->addAndWhere('is_del=0');

        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    public static function getPhone($user_id,$phone_model){
        if(!$user_id || !$phone_model)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('phone s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('phone_model="'.$phone_model.'"');
        $obj->addAndWhere('is_del=0');

        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    public static function getPhoneById($user_id,$phone_id){
        if(!$user_id || !$phone_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('phone s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('id="'.$phone_id.'"');

        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    public static function insertPhone($fileds){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->insert('phone',$fileds);
    }

    public static function updateStatus($phone_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->update('phone',['is_del'=>1],'id='.$phone_id);
    }

}