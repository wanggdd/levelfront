<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

$userid = $zz_userid;
$username = USER_USER_NAME;
$avatar = USER_USER_HEAD_PIC;

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;
$zz_user_info = Model_Member::getMemberByUser($userid);
$zz_user_user = Model_User::getUserById($userid);
$username = !empty($zz_user_user[0]['nick_name'])?$zz_user_user[0]['nick_name']:$zz_user_user[0]['user_name'];
$qrcode = $zz_user_info?$zz_user_info[0]['payment_code']:'';
$smarty->assign('username',$zz_user_info[0]);
$smarty->assign('userid',$userid);
$smarty->assign('qrcode',$qrcode);
$smarty->display('userinfo/editinfo.tpl');