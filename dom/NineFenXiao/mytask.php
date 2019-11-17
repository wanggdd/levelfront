<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/setting.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/public.php';

$userid = USER_USER_ID;
$username = USER_USER_NAME;
$avatar = USER_USER_HEAD_PIC;

use Model\WebPlugin\Model_Member;
use Model\WebPlugin\Model_PaymentRecord;

$memberinfo = Model_Member::getMemberByUser($userid);
//打款记录
if(!$memberinfo){
    die('no user');
}
$status = $memberinfo[0]['status'];
$wait_pay_record = 0;
if($status == 1){
  $wait_pay_record_count = Model_PaymentRecord::getActRecord($userid);
  if($wait_pay_record_count==0){ //如果一条也没有说明激活任务没执行所以还有2条待付款
      $wait_pay_record = 2;
  }else if($wait_pay_record_count<=2){ //这样可以保证只有小于等于两条任务数
      $wait_pay_record = 2 - $wait_pay_record_count;
  }
}else if($status == 2){

}

//待收款记录
$reward_record = Model_PaymentRecord::getWaitPayRecord($userid,1);

$smarty->assign('pay_record',$wait_pay_record);
$smarty->assign('reward_record',$reward_record);
$smarty->assign('zz_userid',$userid);
$smarty->display('other/await.tpl');