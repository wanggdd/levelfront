<?php
//待收款任务

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;


$smarty->display('other/await_gathering_list.tpl');