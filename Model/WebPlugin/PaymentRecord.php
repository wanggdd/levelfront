<?php

namespace Model\WebPlugin;

class Model_PaymentRecord extends \Model
{

    //��ȡ���տ��б�
    public static function getWaitEnterList($user_id = 0){
        if(!$user_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record s');

        $obj->addAndWhere('enter_member='.$user_id);
        $obj->addAndWhere('status=1');
        $obj->addOrWhere('status=3');

        return $obj->query(false);
    }

    /*
     * $fileds where����
     * $enter ���or�տ�  Ĭ���տtrue
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
        $obj->addAndWhere('out_member='.$user_id);
        $obj->addAndWhere('payment_type=2');
        return $obj->count();
    }

    /**
     * �����ո����¼ƾ֤
     * @param $user_id
     * @param $evidence
     * @param string $type  out|enter ���|�տ�
     * @return mixed
     */
    public static function saveEvidence($id,$evidence,$type='out'){

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->update('payment_record p',['payment_voucher'=>$evidence],'id='.$id);
    }

    public static function updateStatus($id,$status){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->update('payment_record p',['status'=>$status,'enter_time'=>time()],'id='.$id);
    }

    public static function updateSet($id,$set){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return  $obj->update('payment_record p',$set,'id='.$id);
    }

    /**
     * ��ȡ�û���������տ��¼����
     * @param $user_id
     * @param int $status
     */
    public static function getWaitPayRecord($user_id,$status=0){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record p');
        $obj->addAndWhere('enter_member='.$user_id);
        $obj->addAndWhere('status='.$status);
        return $obj->count();
    }
}