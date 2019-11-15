<?php
//邀请好友

include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;

function cget($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $dom = curl_exec($ch);
    curl_close($ch);
    return $dom;
}

//获取member信息
$zz_userid = 1;
$memebr = Model_Member::getMemberByUser($zz_userid);
$invite_code = $memebr[0]['invite_code'];
//获取user信息
$user = Model_User::getUserById($zz_userid);
$user_name = $user[0]['user_name'];
$user_id = $user[0]['user_id'];
if(!$invite_code){
    //写入分享码
    //$content = file_get_contents('http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$zz_userid);
    $url = 'http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$user_id;
    $content = cget($url);
    if($content){
        $res = json_decode($content,true);
        if($res&&$res['status']=='200'){ //二维码获取成功更新到数据中
            $img = $res['list']['returnUrl'];
            $invite_code = $img;
            $status = Model_Member::updateQrcode($zz_userid,$img,'share');
            if(!$status){  //保存失败的错误处理
                //todo
            }

        }

    }

}

$smarty->assign('invite_code',$invite_code);
$smarty->display('other/share.tpl');

