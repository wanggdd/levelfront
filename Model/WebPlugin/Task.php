<?php

//处理升级和激活
namespace Model\WebPlugin;

class Model_Task extends \Model
{
    //已经激活的人的任务列表
    /**
     * 先获取当前会员要升级到的等级i,找第i层的人(就找第i层的人，中间不退出)，如果i层的会员>=i级，则给第i层的人打款。
     * 若没有第i层直接给最高等级的初始会员打。
     * 若有第i层，却不>=i级，则再向上找3层(遇见则停止)，一直到3层还没有符合的，则给最高等级的初始会员打
     * @param $user_id int  当前网站所属ID
     * @param $user_user_id int  当前会员ID
     */
    public function getThree($user_id,$user_user_id){
        $return = array();
        $task_member = array();
        //先获取当前会员的等级
        $member = Model_Member::getMemberByUser($user_id,$user_user_id);
        if(!$member[0]['higher_id'])
            return $return;
        $current_grade = $member[0]['grade'];//此数值是grade的主键

        //获取最高等级
        $max_grade = Model_Grade::getMaximumGrade($user_id,'desc');
        if($current_grade == $max_grade)//当前是最高等级时，返回
            return $return;

        /* --------------以下逻辑，是在排序值=等级，且1-9级，中间无断层的前提进行的-------------- */
        $current_info = Model_Grade::getGradeByGrade($current_grade,$user_id);
        $next_grade = Model_Grade::getNextGrade($user_id,$current_info['grade']);

        //获得所有大于当前等级的等级组合
        $up_info = Model_Grade::getNextGrades($user_id,$current_info['grade']);
        if(!$up_info)
            return $return;

        $grade_ids = array();
        foreach($up_info as $key=>$item){
            $grade_ids[] = $item['id'];
        }

        $i = 1;
        $member_info = array();
        $higher_id = $member[0]['higher_id'];
        while($i <= $next_grade['grade']){
            $info = $this->nineUser($user_id,$higher_id);
            if(!$info){
                break;
            }
            $member_info = $info['member_info'];
            $higher_id = $info['higher_id'];
            $i++;
        }
        $level = $i-1;
        //找到了上层第i层的会员
        if($level == $next_grade['grade']){
            //判断此会员是否>=上一级
            if(in_array($member_info['grade'],$grade_ids)){
                $task_member = $member_info;
            }else{
                //再向上找3层
                $member1 = Model_Member::getMemberByUser($user_id,$member_info['higher_id']);
                if(!$member1)
                    return $return;

                if(in_array($member1[0]['grade'],$grade_ids)){
                    $task_member = $member1[0];
                }else{
                    $member2 = Model_Member::getMemberByUser($user_id,$member1[0]['higher_id']);
                    if(!$member2)
                        return $return;

                    if(in_array($member2[0]['grade'],$grade_ids)){
                        $task_member = $member2[0];
                    }else{
                        $member3 = Model_Member::getMemberByUser($user_id,$member2[0]['higher_id']);
                        if(!$member3)
                            return $return;

                        if(in_array($member3[0]['grade'],$grade_ids)) {
                            $task_member = $member3[0];
                        }else{
                            //找最高等级的初始会员
                            $member4 = Model_Member::getMemberByUser($user_id,$max_grade['user_user_id']);
                            if(!$member4)
                                return $return;

                            $task_member = $member4[0];
                        }
                    }

                }
            }
        }else{
            //找最高等级的初始会员
            $member4 = Model_Member::getMemberByUser($user_id,$max_grade['user_user_id']);
            if(!$member4)
                return $return;

            $task_member = $member4[0];
        }
        /* --------------以上逻辑，是在排序值=等级值的前提下进行的-------------- */



        //往上查3层，是否有等级大于当前等级的会员
        /*$task_member = array();
        $member1 = Model_Member::getMemberByUser($user_id,$member[0]['higher_id']);
        if(!$member1)
            return $return;

        if(in_array($member1[0]['grade'],$grade_ids)){
            $task_member = $member1[0];
        }else{
            $member2 = Model_Member::getMemberByUser($user_id,$member1[0]['higher_id']);
            if(!$member2)
                return $return;

            if(in_array($member2[0]['grade'],$grade_ids)){
                $task_member = $member2[0];
            }else{
                $member3 = Model_Member::getMemberByUser($user_id,$member2[0]['higher_id']);
                if(!$member3)
                    return $return;

                if(in_array($member3[0]['grade'],$grade_ids)) {
                    $task_member = $member3[0];
                }else{
                    $sys_up = Model_Grade::getNextGrade($user_id,$current_info['grade']);
                    $member4 = Model_Member::getMemberByUser($user_id,$sys_up['user_user_id']);
                    if(!$member4)
                        return $return;

                    $task_member = $member4[0];
                }
            }

        }*/

        //查找获取到的user_id的用户名
        if($task_member){
            $user_info = Model_User::getUserById($user_id,$task_member['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
            $return['enter_member'] = $task_member['user_user_id'];

            //等级信息
            $last_grade = Model_Grade::getGradeByGrade($task_member['grade'],$user_id);
            $return['promote_money']    = $last_grade['promote_money'];
            $return['grade_title']      = '升级'.$last_grade['title'].'任务';
            $return['promote_type']     = 1;
            $return['out_member']       = $user_user_id;
            $return['task_grade']       = $last_grade['id'];
        }
        return $return;
    }

    //未激活的人的第九层级，若上面没有九层，就给系统设置的最高等级的默认会员打
    /**
     * @param $user_id int  当前网站所属ID
     * @param $user_user_id int  当前会员ID
     */
    public function getNine($user_id,$user_user_id){
        //获取系统当前等级的层数
        $max_grade = Model_Grade::getGradeCount($user_id);
        //当前用户的上级
        $member = Model_Member::getMemberByUser($user_id,$user_user_id);
        $higher_id = $member[0]['higher_id'];
        $i = 1;
        $member_info = array();
        while($i <= $max_grade){
            $info = $this->nineUser($user_id,$higher_id);
            if(!$info){
                break;
            }
            $member_info = $info['member_info'];
            $higher_id = $info['higher_id'];
            $i++;
        }
        $level = $i-1;
        $return = array();
        $exist = false;
        $return['promote_type']     = 2;
        $return['task_grade']       = 2;
        $return['status_title']     = '待打款';
        if($level == $max_grade){
            $return['out_member'] = $user_user_id;
            $return['enter_member'] = $member_info['user_user_id'];
            $user_info = Model_User::getUserById($user_id,$member_info['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
            //获取等级信息
            if($member_info['grade']){
                $last_grade = Model_Grade::getGradeByGrade($member_info['grade'],$user_id);
                $return['promote_money']    = $last_grade['promote_money'];
            }else{
                $exist = true;
            }
        }else{
            $exist = true;
        }

        if($exist){
            //没有查到第九层，则找默认的人
            $grade = Model_Grade::getMaximumGrade($user_id);
            if($grade['user_user_id']){
                $return['out_member']   = $user_user_id;
                $return['enter_member'] = $grade['user_user_id'];
                $user_info = Model_User::getUserById($user_id,$grade['user_user_id']);
                $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                //查找默认打款金额
                $setting_info = Model_Setting::getSetting($user_id);
                $money = $setting_info['noactive_active_money'];
                $return['promote_money'] = $money;
            }
        }

        return $return;
    }


    public function nineUser($user_id,$higher_id){
        $member = Model_Member::getMemberByUser($user_id,$higher_id);
        if($member){
            return array('higher_id'=>$member[0]['higher_id'],'member_info'=>$member[0]);
        }else{
            return false;
        }
    }

}
