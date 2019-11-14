<?php
//��������
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_User;

//��ȡ��ǰ����

//����¼
$out_info = Model_PaymentRecord::getRecordByUser(array('user_id'=>$zz_user_info['id']),false);
$out_record = $out_info['record'];
$out_sum = $out_info['sum'];
if($out_record){
    foreach ($out_record as $key=>$item){
        $user_info = Model_User::getUserById($item['enter_member']);
        $out_record[$key]['enter_user'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
        $out_record[$key]['pic'] = $user_info[0]['pic'] ? $user_info[0]['pic'] : 'http://aimg8.dlszyht.net.cn/default/user_user_profile.jpg';
        if($item['payment_type'] == 1){
            $out_record[$key]['payment_type'] = '��������';
        }else if($item['payment_type'] == 2){
            $out_record[$key]['payment_type'] = '��������';
        }
    }
}

//�տ��¼
$enter_info = Model_PaymentRecord::getRecordByUser(array('user_id'=>$zz_user_info['id']));
$enter_record = $enter_info['record'];
$enter_sum = $enter_info['sum'];
if($enter_record){
    foreach ($enter_record as $key=>$item){
        $user_info = Model_User::getUserById($item['out_member']);
        $enter_record[$key]['enter_user'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
        $enter_record[$key]['pic'] = $user_info[0]['pic'] ? $user_info[0]['pic'] : 'http://aimg8.dlszyht.net.cn/default/user_user_profile.jpg';
        if($item['payment_type'] == 1){
            $enter_record[$key]['payment_type'] = '��������';
        }else if($item['payment_type'] == 2){
            $enter_record[$key]['payment_type'] = '��������';
        }
    }
}


$smarty->assign('out_record', $out_record);
$smarty->assign('enter_record', $enter_record);
$smarty->assign('enter_record', $enter_record);
$smarty->assign('out_sum', $out_sum);
$smarty->assign('enter_sum', $enter_sum);
$smarty->display('pay/history.tpl');



