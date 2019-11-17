<?php
//���������

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_Setting;
use Model\WebPlugin\Model_User;
use Model\WebPlugin\Model_Task;

$uid = USER_ID;
$userid = USER_USER_ID;
$status = $current_member['status'];

if($status == 0)
    die('��״̬�û���������������ϵ�����ϼ�����������');

$task_list = array();
//δ����״̬
if($status == 1){
    //�жϼ�¼�����Ƿ��Ѿ������˸��ϼ����Ĵ���¼
    $record = Model_PaymentRecord::getRecord(array('out_member'=>$userid,'payment_type'=>2,'task_grade'=>1));
    if($record){
        $user_info = Model_User::getUserById($record[0]['enter_member']);
        $user_info = $user_info[0];
        $task_list1 = array(
            'record_id'     => $record[0]['id'],
            'nick_name'     => $user_info['nick_name'] ? $user_info['nick_name'] : $user_info['user_name'],
            'grade_title'   => '��������',
            'promote_money' => $record[0]['promote_money'],
            'status_title'  => $record[0]['status'] == 1 ? '�Ѵ����տ�' : '�Ѿܾ�',
            'payment_type'  => 1,
        );
    }else{
        //�ϼ���Ϣ
        $higher_info = Model_User::getUserById($current_member['higher_id']);
        $higher_info = $higher_info[0];
        //����ϼ������
        $setting_info = Model_Setting::getSetting($uid);
        $money = $setting_info['nostate_active_money'];

        $task_list1 = array(
            'nick_name' => $higher_info['nick_name'] ? $higher_info['nick_name'] : $higher_info['user_name'],
            'grade_title'   => '��������',
            'promote_money' => $money,
            'status_title'  => '�����',
            'payment_type'  => 1,
            'enter_member'  => $current_member['higher_id'],
        );
    }

    //�жϼ�¼�����Ƿ��Ѿ������˸��ھŲ㼶���Ĵ���¼
    $record2 = Model_PaymentRecord::getRecord(array('out_member'=>$userid,'payment_type'=>2,'task_grade'=>2));
    if($record2){
        $user_info = Model_User::getUserById($record2[0]['enter_member']);
        $user_info = $user_info[0];
        $task_list2 = array(
            'record_id'     => $record2[0]['id'],
            'nick_name'     => $user_info['nick_name'] ? $user_info['nick_name'] : $user_info['user_name'],
            'grade_title'   => '��������',
            'promote_money' => $record2[0]['promote_money'],
            'status_title'  => $record2[0]['status'] == 1 ? '�Ѵ����տ�' : '�Ѿܾ�',
            'payment_type' => 1
        );
    }else{
        $task_model = new Model_Task();
        $task_list2 = $task_model->getNine($uid,$user_id);
    }

    $smarty->assign('task_list1',$task_list1);
    $smarty->assign('task_list2',$task_list2);

}

//�Ѽ���״̬����Ҫ����
if($status == 2){

    $task_list = Model_Task::getThree($uid,$userid);
    if($task_list){
        foreach($task_list as $key=>$item){
            $info = Model_PaymentRecord::getRecord(
                array('out_member'=>$item['out_member'],'enter_member'=>$item['enter_member'],'task_grade'=>$item['up_grade'],'user_id'=>$uid)
            );
            //֤���������Ѿ���payment�����ˣ��϶��Ѿ�������ز���
            if($info){
                $task_list['record_id'] = $info[0]['id'];
                if($info[0]['status'] == 1){
                    $task_list['status_title'] = '�Ѵ����տ�';
                }
                if($info[0]['status'] == 3){
                    $task_list['status_title'] = '�Ѿܾ�';
                }
            }else{
                $task_list['status_title'] = '�����';
            }
        }
    }

    $smarty->assign('task_list',$task_list);
}

$smarty->assign('zz_userid',$userid);
$smarty->assign('status',$status);
$smarty->display('pay/await_remit_list.tpl');
