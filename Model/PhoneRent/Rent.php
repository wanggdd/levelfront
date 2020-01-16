<?php

namespace Model\PhoneRent;

class Model_Rent extends \Model
{
    public static function getRentList($user_id,$phone_id){
        if(!$user_id || !$phone_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('rent s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('phone_id="'.$phone_id.'"');
        $obj->addAndWhere('is_del=0');
        $obj->addOrderBy('create_time','desc');
        return $obj->query(false);
    }

    public static function getRentInfo($user_id,$rent_id){
        if(!$user_id || !$rent_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('rent s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('id="'.$rent_id.'"');

        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    public static function insertRent($fileds){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->insert('rent',$fileds);
    }

    public static function updateStatus($rent_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->update('rent',['is_del'=>1],'id='.$rent_id);
    }

    public static function getSumPrice($user_id,$phone_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('rent s','sum(rent_price) as sum_price');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('phone_id="'.$phone_id.'"');

        $result = $obj->query(false);
        $sum_price = $obj->sum('rent_price','float');

        return $sum_price;
    }

}