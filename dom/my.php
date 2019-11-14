<?php
error_reporting(E_ALL);

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_Member;


$smarty->assign('zz_user_nfo', $zz_user_info);
$smarty->display('userinfo/userinfo.tpl');