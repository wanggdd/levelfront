<?php
//�ҵ�
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_Grade;
use Model\WebPlugin\Model_User;

$current_members= Model_Member::getMemberByUser($zz_userid);
$current_member = $current_members[0];
//��ȡ�ȼ�
$grade = Model_Grade::getGradeByGrade($current_member['grade']);
if($grade){
    $zz_user_info['grade_title'] = $grade['title'];
}else{
    $zz_user_info['grade_title'] = '';
}

//��ȡ�ϼ���
$higher_user = Model_User::getUserById($current_member['higher_id']);
if($higher_user){
    $zz_user_info['higher_user'] = $higher_user[0]['nick_name'] ? $higher_user[0]['nick_name'] : $higher_user[0]['user_name'];
}
//var_dump($zz_user_info);exit;

$smarty->assign('zz_user_info', $zz_user_info);
$smarty->assign('current_member', $current_member);
$smarty->display('userinfo/userinfo.tpl');