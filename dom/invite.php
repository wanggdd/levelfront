<?php
//邀请好友

include_once $_SERVER['DOCUMENT_ROOT'].'/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;

//获取member信息
$memebr = Model_Member::getMemberByUser($zz_userid);
$invite_code = $memebr[0]['invite_code'];

//获取user信息
$user = Model_User::getUserById($zz_userid);
$user_name = $user[0]['user_name'];

if(!$invite_code){
    //写入分享码
    //$content = file_get_contents('http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$zz_userid);
    $url = 'http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$zz_userid;
    $content = Functions::post($url);
    var_dump($content);exit;
    //Model_Member::updateQrcode($zz_userid,'');
}



