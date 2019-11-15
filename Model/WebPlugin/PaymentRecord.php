<?php

namespace Model\WebPlugin;

class Model_PaymentRecord extends \Model
{
    /*
     * $fileds where条件
     * $enter 打款or收款  默认收款：true
     */
    public static function getRecordAndSum($fileds = array(),$enter = true){
        if(!$fileds)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record s');

        $obj->addAndWhere('status=2');

        if($enter){
            $obj->addAndWhere('enter_member='.$fileds['user_id']);
        }else{
            $obj->addAndWhere('out_member='.$fileds['user_id']);
        }
        if($fileds['start_time'])
            $obj->addAndWhere('enter_time>='.$fileds['start_time']);
        if($fileds['end_time'])
            $obj->addAndWhere('enter_time<'.$fileds['end_time']);

        $record = $obj->query(false);

        $sum_value = $obj->sum('payment_money','float');
        $sum = $sum_value ? $sum_value : '0.00';

        return array('record'=>$record,'sum'=>$sum);
    }

    public static function getRecord($id = 0){
        if(!$id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record s');

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