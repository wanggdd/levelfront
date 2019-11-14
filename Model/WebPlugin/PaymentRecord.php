<?php

namespace Model\WebPlugin;

class Model_PaymentRecord extends \Model
{
    /*
     * $user_id 当前会员id
     * $enter 打款or收款  默认收款：true
     */
    public static function getRecordByUser($fileds = array(),$enter = true){
        if(!$fileds)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record s');

        $obj->addAndWhere('status=2');

        if($enter){
            //$obj->addAndWhere('enter_member='.$fileds['user_id']);
            $obj->addAndWhere('enter_member='.$fileds['user_id']);
        }else{
            $obj->addAndWhere('out_member='.$fileds['user_id']);
        }

        $record = $obj->query(false);
        $sum_value = $obj->sum('payment_money','float');
        $sum = $sum_value ? $sum_value : '0.00';

        return array('record'=>$record,'sum'=>$sum);
    }

    public static function getUserById($id = 0){
        if(!$id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('user_user s');
        $obj->addAndWhere('id='.$id);
        return $obj->query(false);
    }

    public static function getActRecord($user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record p');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('payment_type=2');
        return $obj->count();
    }

    /**
     * 获取用户待打款或代收款记录集合
     * @param $user_id
     * @param int $status
     */
    public static function getWaitPayRecord($user_id,$status=0){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record p');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('status='.$status);
        return $obj->count();
    }
}