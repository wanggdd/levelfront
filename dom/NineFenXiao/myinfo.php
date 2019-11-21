<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

$uid = USER_ID;
$userid = USER_USER_ID;
$username = USER_USER_NAME;
$avatar = USER_USER_HEAD_PIC;

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;
$zz_user_info = Model_Member::getMemberByUser($uid,$userid);
$zz_user_user = Model_User::getUserById($uid,$userid);
$username = !empty($zz_user_user[0]['nick_name'])?$zz_user_user[0]['nick_name']:$zz_user_user[0]['user_name'];
$qrcode = $zz_user_info?$zz_user_info[0]['payment_code']:'';
$avatar = !empty($zz_user_user[0]['pic'])?$zz_user_user[0]['pic']:'/public/images/userInfo/icon-avatar.png';
$smarty->assign('username',$username);
$smarty->assign('avatar',$avatar);
$smarty->assign('userid',$userid);
$smarty->assign('qrcode',$qrcode);
$smarty->display('userinfo/editinfo.tpl');