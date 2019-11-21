<?php

//我的下级
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;
use Model\WebPlugin\Model_Grade;

$uid = USER_ID;
$userid = USER_USER_ID;

$lowerList  = array();
$count      = 0;

$lower_info = Model_Member::getLowerListAndCount($uid,$userid);
if($lower_info){
    $lowerList  = $lower_info['record'];
    $count      = $lower_info['count'];
    foreach($lowerList as $key=>$item){
        $user_info = Model_User::getUserById($uid,$item['user_user_id']);
        $lowerList[$key]['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
        $lowerList[$key]['pic'] = $user_info[0]['pic'] ? $user_info[0]['pic'] : 'http://aimg8.dlszyht.net.cn/default/user_user_profile.jpg';

        $grade = Model_Grade::getGradeByGrade($item['grade'],$uid);
        $lowerList[$key]['grade'] = $grade['title'];
        $lowerList[$key]['create_time'] = date('Y-m-d H:i:s',$item['create_time']);
    }
}else{
    $lowerList  = NULL;
    $count      = 0;
}

//var_dump($lowerList);exit;

$smarty->assign('lowerList',$lowerList);
$smarty->assign('count',$count);
$smarty->display('other/branch.tpl');