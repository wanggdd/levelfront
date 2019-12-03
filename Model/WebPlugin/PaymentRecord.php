<?php

namespace Model\WebPlugin;

class Model_PaymentRecord extends \Model
{

    //获取待收款列表
    public static function getWaitEnterList($user_id,$user_user_id){

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $sql = 'select * from payment_record where user_id='.$user_id.' and enter_member='.$user_user_id.' and (status=1 or status=3) and is_del=0';

        //return $obj->sqlQuery(false);
        return $obj->sqlQuery($sql,'get_results');
    }

    /*
     * $fileds where条件
     * $enter 打款or收款  默认收款：true
     */
    public static function getRecordAndSum($user_id,$fileds = array(),$enter = true){
        if(!$fileds)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record s');

        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('is_del=0');
        $obj->addAndWhere('status=2');

        if($enter){
            $obj->addAndWhere('enter_member='.$fileds['member_id']);
        }else{
            $obj->addAndWhere('out_member='.$fileds['member_id']);
        }
        if($fileds['start_time'])
            $obj->addAndWhere('enter_time>='.$fileds['start_time']);
        if($fileds['end_time'])
            $obj->addAndWhere('enter_time<'.$fileds['end_time']);

        $record = $obj->query(false);
//echo $obj->getSQL();echo '<br>';
        $sum_value = $obj->sum('payment_money','float');
        $sum = $sum_value ? $sum_value : '0.00';

        return array('record'=>$record,'sum'=>$sum);
    }

    //获取记录
    public static function getRecord($user_id,$fileds = array()){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('is_del=0');
        if($fileds){
            foreach($fileds as $key=>$item){
                $obj->addAndWhere($key.'='.$item);
            }
        }

        //$obj->query(false);
        //echo $obj->getSQL();
        return $obj->query(false);
    }

    public static function getActRecord($user_id,$user_user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record p');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('is_del=0');
        $obj->addAndWhere('out_member='.$user_user_id);
        $obj->addAndWhere('payment_type=2');
        $obj->addAndWhere('(status=1');
        $obj->addOrWhere('status=3)');
        return $obj->count();
    }

    public static function getActFinishRecord($user_id,$user_user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record p');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('is_del=0');
        $obj->addAndWhere('out_member='.$user_user_id);
        $obj->addAndWhere('payment_type=2');
        $obj->addAndWhere('status=2');
        return $obj->count();
    }

    /**
     * 保存收付款记录凭证
     * @param $user_id
     * @param $evidence
     * @param string $type  out|enter 打款|收款
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
     * 获取用户待打款或代收款记录集合
     * @param $user_id
     * @param int $status
     */
    public static function getWaitPayRecord($user_id,$user_user_id,$status=0){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('payment_record p');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addAndWhere('is_del=0');
        $obj->addAndWhere('enter_member='.$user_user_id);
        $obj->addAndWhere('(status=1');
        $obj->addOrWhere('status=3)');
        return $obj->count();
    }

    public static function insertRecord($fileds){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->insert('payment_record',$fileds);
    }

    public static function getCount($user_id,$user_user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $sql = 'select count(distinct out_member) as num from payment_record where user_id='.$user_id.' and enter_member='.$user_user_id.' and status=2 and payment_type=1 and is_del=0';
        return $obj->sqlQuery($sql,'get_row');
    }
}