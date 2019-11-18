<?php

namespace Model\WebPlugin;
use Model\WebPlugin\Model_Grade;
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

    public static function getMemberJonUser($fileds){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('member s,user u');
        if($fileds){
            foreach($fileds as $key=>$item){
                $obj->addAndWhere($key.'='.$item);
            }
        }

        return $obj->query(false);
    }

    /**
     * @param $uid
     * @param $qrcode
     * @param string $type  =reward是收款二维码 share=分享二维码
     * @return mixed
     */
    public static function updateQrcode($uid,$qrcode,$type = 'reward'){
        $field = $type == 'reward'?'payment_code':'invite_code';

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->update('member s',[$field=>$qrcode],'user_user_id='.$uid);
    }

    public static function getLowerListAndCount($user_id = 0){
        if(!$user_id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('member s');
        $obj->addAndWhere('higher_id='.$user_id);

        $record = $obj->query(false);
        if($record){
            $count = $obj->count();
            return array('record'=>$record,'count'=>$count);
        }
        return fasle;
    }

    public static function getLowerCount($user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('member s');
        $obj->addAndWhere('higher_id='.$user_id);
        return $obj->count();
    }

    public static function upInfo($fileds,$user_user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        return $obj->update('member s',$fileds,'user_user_id='.$user_user_id);
    }

    //激活 从1-2
    public static function active($uid,$admin_id=1){
        //找出grade表中主键
        $grades = Model_Grade::getGrade(['user_id'=>$admin_id,'grade'=>1]);
        $gid = 0;
        if(isset($grades[0])){
            $gid = $grades[0]['id'];
        }

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->update('member s',['status'=>2,'grade'=>$gid],'user_user_id='.$uid);

        //查看此会员是否有下级，若有下级需要将下级的状态改为未激活，就可以做邀请下级的任务了
        $list = self::getLowerListAndCount($uid);
        if($list){
            foreach($list['record'] as $key=>$item){
                self::upInfo(array('status'=>1),$item['user_user_id']);
            }
        }

        return true;
    }

    //通过grade_id查找会员
    public static function getInfoByGradeId($user_user_id,$grade_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('member s');
        $obj->addAndWhere('user_user_id='.$user_user_id.' and grade='.$grade_id);
        $result = $obj->query(false);
        //echo $obj->getSql();
        if($result)
            return $result[0];
        return false;
    }

}