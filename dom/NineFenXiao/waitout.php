<?php
//待打款任务

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_Setting;
use Model\WebPlugin\Model_User;
use Model\WebPlugin\Model_Task;

$uid = USER_ID;
$userid = USER_USER_ID;
$username = USER_USER_NAME;
$status = $current_member['status'];

if($status == 0)
    die('无状态用户不能升级，请联系您的上级尽快升级！');

$task_list = array();
//未激活状态
if($status == 1){
    //判断记录表里是否已经生成了给上级打款的打款记录
    $record = Model_PaymentRecord::getRecord($uid,array('out_member'=>$userid,'payment_type'=>2,'task_grade'=>1));
    if($record){
        $user_info = Model_User::getUserById($uid,$record[0]['enter_member']);
        $user_info = $user_info[0];
        $task_list1 = array(
            'record_id'     => $record[0]['id'],
            'nick_name'     => $user_info['nick_name'] ? $user_info['nick_name'] : $user_info['user_name'],
            'grade_title'   => '激活任务',
            'promote_money' => $record[0]['promote_money'],
            'payment_type'  => 1,
        );
        if($record[0]['status']==1){
            $task_list1['status_title'] = '已打款待收款';
        }else if($record[0]['status']==2){
            $task_list1 = [];
        }else if($record[0]['status']==3){
            $task_list1['status_title'] = '已拒绝';
        }else{
            $task_list1 = [];
        }

    }else{
        //上级信息
        $higher_info = Model_User::getUserById($uid,$current_member['higher_id']);
        if(isset($higher_info[0])) { //如果有上级才有激活任务
            $higher_info = $higher_info[0];
            //需给上级打款金额
            $setting_info = Model_Setting::getSetting($uid);
            $money = $setting_info['nostate_active_money'];

            $task_list1 = array(
                'nick_name' => $higher_info['nick_name'] ? $higher_info['nick_name'] : $higher_info['user_name'],
                'grade_title' => '激活任务',
                'promote_money' => $money,
                'status_title' => '待打款',
                'payment_type' => 1,
                'enter_member' => $current_member['higher_id'],
            );
        }
    }

    //判断记录表里是否已经生成了给第九层级打款的打款记录
    $record2 = Model_PaymentRecord::getRecord($uid,array('out_member'=>$userid,'payment_type'=>2,'task_grade'=>2));
    if($record2){
        $user_info = Model_User::getUserById($uid,$record2[0]['enter_member']);
        $user_info = $user_info[0];
        $task_list2 = array(
            'record_id'     => $record2[0]['id'],
            'nick_name'     => $user_info['nick_name'] ? $user_info['nick_name'] : $user_info['user_name'],
            'grade_title'   => '激活任务',
            'promote_money' => $record2[0]['promote_money'],
            'payment_type' => 1
        );
        if($record2[0]['status']==1){
            $task_list2['status_title'] = '已打款待收款';
        }else if($record2[0]['status']==2){
            $task_list2 = [];
        }else if($record2[0]['status']==3){
            $task_list2['status_title'] = '已拒绝';
        }else{
            $task_list2 = [];
        }
    }else{
        $task_model = new Model_Task();
        $task_list2 = $task_model->getNine($uid,$userid);
    }

    $smarty->assign('task_list1',$task_list1);
    $smarty->assign('task_list2',$task_list2);

}

//已激活状态，需要晋升
if($status == 2){
    $task_list = Model_Task::getThree($uid,$userid);
    if($task_list){
        $info = Model_PaymentRecord::getRecord($uid,
            array('out_member'=>$task_list['out_member'],'enter_member'=>$task_list['enter_member'],'task_grade'=>$task_list['task_grade'],'user_id'=>$uid)
        );
        //证明此任务已经在payment表里了，肯定已经做过相关操作
        if($info){
            $task_list['record_id'] = $info[0]['id'];
            if($info[0]['status'] == 1){
                $task_list['status_title'] = '已打款待收款';
            }
            if($info[0]['status'] == 3){
                $task_list['status_title'] = '已拒绝';
            }
        }else{
            $task_list['status_title'] = '待打款';
        }
    }
    //var_dump($task_list);exit;

    $smarty->assign('task_list',$task_list);
}

$smarty->assign('zz_userid',$userid);
$smarty->assign('username',$username);
$smarty->assign('status',$status);
$smarty->display('pay/await_remit_list.tpl');
