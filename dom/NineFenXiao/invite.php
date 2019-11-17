<?php
//邀请好友

include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_User;

$userid = USER_USER_ID;

function cget($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $dom = curl_exec($ch);
    curl_close($ch);
    return $dom;
}

//获取member信息
$invite_code = $current_member['invite_code'];
if(!$invite_code){
    //写入分享码
    //$content = file_get_contents('http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$zz_userid);
    $url = 'http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.USER_USER_NICK_NAME.'&zz_userid='.$userid;
    $content = cget($url);
    if($content){
        $res = json_decode($content,true);
        if($res&&$res['status']=='200'){ //二维码获取成功更新到数据中
            $img = $res['list']['returnUrl'];
            $invite_code = $img;
            $status = Model_Member::updateQrcode($userid,$img,'share');
            if(!$status){  //保存失败的错误处理
                //todo
            }

        }

    }

}

$smarty->assign('invite_code',$invite_code);
$smarty->display('other/share.tpl');

