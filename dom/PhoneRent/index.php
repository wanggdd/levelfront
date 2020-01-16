<?php
//ÎÒµÄ
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_Grade;
use Model\WebPlugin\Model_User;

$uid = USER_ID;
$userid = USER_USER_ID;
$username = USER_USER_NAME;



$smarty->display('phonerent/index.tpl');