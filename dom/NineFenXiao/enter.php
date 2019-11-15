<?php
//收款记录详情

include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\WebPlugin\Model_PaymentRecord;
use Model\WebPlugin\Model_User;
use Model\WebPlugin\Model_Member;

$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

//打款信息
$record = Model_PaymentRecord::getRecord($id);
$record_info = $record[0];
$record_info['out_time'] = date('Y-m-d H:i:s',$record_info['out_time']);
$record_info['enter_time'] = date('Y-m-d H:i:s',$record_info['enter_time']);


//用户信息
$user = Model_User::getUserById($record[0]['out_member']);
$user_info = $user[0];
$user_info['nick_name'] = $user_info['nick_name'] ? $user_info['nick_name'] : $user_info['user_name'];

//收款二维码
$member = Model_Member::getMemberByUser($record_info['out_member']);

$smarty->assign('record', $record_info);
$smarty->assign('user_info', $user_info);
$smarty->assign('member_info', $member[0]);
$smarty->display('pay/gathering_info.tpl');