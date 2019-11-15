<?php
//待打款任务

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;

$status = $current_member['status'];

$smarty->assign('pay_record',$wait_pay_record);
$smarty->assign('reward_record',$reward_record);
$smarty->display('other/await_remit_list.tpl');
