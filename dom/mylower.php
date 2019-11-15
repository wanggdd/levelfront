<?php

//我的下级
include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;
use Model\WebPlugin\Model_Grade;

$lower_info = Model_Member::getLowerListAndCount($zz_userid);
$lowerList  = $lower_info['record'];
$count      = $lower_info['count'];

if($lowerList){
    foreach($lowerList as $key=>$item){
        $user_info = Model_User::getUserById($item['user_user_id']);
        $lowerList[$key]['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
        $lowerList[$key]['pic'] = $user_info[0]['pic'] ? $user_info[0]['pic'] : 'http://aimg8.dlszyht.net.cn/default/user_user_profile.jpg';

        $grade = Model_Grade::getGradeByGrade($item['grade']);
        $lowerList[$key]['grade'] = $grade['title'];
        $lowerList[$key]['create_time'] = date('Y-m-d H:i:s',$item['create_time']);
    }
}

//var_dump($lowerList);exit;

$smarty->assign('lowerList',$lowerList);
$smarty->assign('count',$count);
$smarty->display('other/branch.tpl');