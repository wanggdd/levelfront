<?php

define('USER_ID', 1); // �û�id
define('USER_NAME', 'wolaiceshi'); // �û���
define('AGENT_ID', 0); // ������id
define('SITE_VIP', 1); // 0 ����û� 1 �����û�
define('IP', trim(getIP2()));
define("HOME_URL", '/'); // ��ҳ��ַ

use Model\WebPlugin\Model_User;
use Model\WebPlugin\Model_Member;

$zz_userid = isset($_REQUEST['zz_userid']) ? (int)$_REQUEST['zz_userid'] : 0;

$zz_user_info = [];
if ($zz_userid) {
    $user_info = Model_User::getUserById($zz_userid);
    $zz_user_info = $user_info[0];

    /*$zz_user_info = [
        'id'         => '248478',
        'user_name'  => 'wolaiceshi',
        'nick_name'  => '��Ӣ��Ѫ��',
        'pic'        => '',
        'input_time' => '2009-11-04 10:19:58', // ע��ʱ��
        'mobile'     => '1111111111111', // �ֻ���
    ];*/

    $zz_user_info['user_user_nick_name'] = $zz_user_info['nick_name'] ? $zz_user_info['nick_name'] : $zz_user_info['user_name'];
    $zz_user_info['user_user_head_pic']  = $zz_user_info['pic'] ? $zz_user_info['pic'] : 'http://aimg8.dlszyht.net.cn/default/user_user_profile.jpg';

    define('USER_USER_ID', $zz_user_info['id']); // ��վ�û�id
    define('USER_USER_NAME', $zz_user_info['user_name']); // ��վ���û����û���
    define('USER_USER_NICK_NAME', $zz_user_info['user_user_nick_name']);
    define('USER_USER_HEAD_PIC', $zz_user_info['user_user_head_pic']); // �û�ͷ��
}

//��ȡmember����Ϣ
$member = Model_Member::getMemberByUser(USER_USER_ID);
$current_member = $member[0];
//var_dump($current_member);exit;