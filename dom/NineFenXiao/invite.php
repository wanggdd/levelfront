<?php
//�������

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

//��ȡmember��Ϣ
$invite_code = $current_member['invite_code'];
if(!$invite_code){
    //д�������
    //$content = file_get_contents('http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.$user_name.'&zz_userid='.$zz_userid);
    $url = 'http://m.evyun.cn/wap/shareAlert/NineFx.php?username='.USER_USER_NICK_NAME.'&zz_userid='.$userid;
    $content = cget($url);
    if($content){
        $res = json_decode($content,true);
        if($res&&$res['status']=='200'){ //��ά���ȡ�ɹ����µ�������
            $img = $res['list']['returnUrl'];
            $invite_code = $img;
            $status = Model_Member::updateQrcode($userid,$img,'share');
            if(!$status){  //����ʧ�ܵĴ�����
                //todo
            }

        }

    }

}

$smarty->assign('invite_code',$invite_code);
$smarty->display('other/share.tpl');

