<?php
//�������

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;

//��ȡmember��Ϣ
$memebr = Model_Member::getMemberByUser($zz_userid);
$invite_code = $memebr[0]['invite_code'];

//��ȡuser��Ϣ
$user = Model_User::getUserById($zz_userid);
$user_name = $user[0]['user_name'];

if(!$invite_code){
    //д�������
    //$content = file_get_contents('http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$zz_userid);
    $url = 'http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$zz_userid;
    $content = Functions::post($url);
    var_dump($content);exit;
    //Model_Member::updateQrcode($zz_userid,'');
}



