<?php
//����¼

include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_User;
use Model\WebPlugin\Model_Member;

$uid = USER_ID;
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

//���Է����տ���Ϣ
$record = Model_PaymentRecord::getRecord($uid,array('id'=>$id));
$record_info = $record[0];
$record_info['out_time'] = date('Y-m-d H:i:s',$record_info['out_time']);
$record_info['enter_time'] = date('Y-m-d H:i:s',$record_info['enter_time']);


//���Է����û���Ϣ
$user = Model_User::getUserById($uid,$record[0]['enter_member']);
$user_info = $user[0];
$user_info['nick_name'] = $user_info['nick_name'] ? $user_info['nick_name'] : $user_info['user_name'];

//���Է����տ��ά��
$member = Model_Member::getMemberByUser($uid,$record_info['enter_member']);

$smarty->assign('record', $record_info);
$smarty->assign('user_info', $user_info);
$smarty->assign('member_info', $member[0]);
$smarty->display('pay/remit_info.tpl');