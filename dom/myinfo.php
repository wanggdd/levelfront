<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

$userid = $zz_userid;
$username = USER_USER_NAME;
$avatar = USER_USER_HEAD_PIC;

use Model\WebPlugin\Model_Member;
$zz_user_info = Model_Member::getMemberByUser($userid);
$qrcode = $zz_user_info?$zz_user_info[0]['payment_code']:'';
$smarty->assign('zz_user_info', $zz_user_info);
$smarty->assign('qrcode',$qrcode);
$smarty->display('userinfo/editinfo.tpl');