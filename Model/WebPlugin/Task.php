<?php

//处理升级和激活
namespace Model\WebPlugin;

class Model_Task extends \Model
{
    //已经激活的人的任务列表(判断自己当前处于什么等级，找到大于自己等级的最近一级，向上查三层，是否有处于此等级的人。 若没有就给此等级的默认人打款)
    /**
     * @param $user_id int  当前网站所属ID
     * @param $user_user_id int  当前会员ID
     */
    public static function getThree($user_id,$user_user_id){
        $return = array();
        //先获取当前会员的等级
        $member = Model_Member::getMemberByUser($user_user_id);
        if(!$member[0]['higher_id'])
            return $return;
        $grade_id = $member[0]['grade'];
        //$grade_info = Model_Grade::getGradeByGrade($grade_id);
        //if($grade_info){
            $current_grade = $grade_id;
            //当前无等级时，获得最低等级
            $max_grade = Model_Grade::getMaximumGrade($user_id);
            if($current_grade == $max_grade['id']){
                $up_info = $max_grade;
            }else{
                //获取当前等级紧挨的上一级
                $up_info = Model_Grade::getNextGrade($user_id,$current_grade);
            }

            $return['promote_money']    = $up_info['promote_money'];
            $return['grade_title']      = '升级'.$up_info['title'].'任务';
            $return['promote_type']     = 2;
            $return['out_member']       = $user_user_id;
            $return['task_grade']       = $up_info['id'];

            //往上查3层，是否有等级是上一级的会员
            $task_member = array();
            $member1 = Model_Member::getInfoByGradeId($member[0]['higher_id'],$up_info['id']);
            if(!$member1){
                $member2 = Model_Member::getInfoByGradeId($member1['higher_id'],$up_info['id']);
                if(!$member2){
                    $member3 = Model_Member::getInfoByGradeId($member2['higher_id'],$up_info['id']);
                    if(!$member3){
                        //没有时，取系统默认值
                        $member4 = Model_Member::getMemberByUser($up_info['user_user_id']);
                        if($member4)
                            $task_member = $member4[0];
                    }else{
                        $task_member = $member3;
                    }
                }else{
                    $task_member = $member2;
                }
            }else{
                $task_member = $member1;
            }

            //查找获取到的user_id的用户名
            if($task_member){
                $user_info = Model_User::getUserById($task_member['user_user_id']);
                $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                $return['enter_member'] = $task_member['user_user_id'];
            }else{
                //没有时，查找等级默认的人
                $info = Model_Grade::getGrade(array('user_id'=>$user_id,'id'=>$up_info['id']));
                if($info[0]['user_user_id']){
                    $user_info = Model_User::getUserById($info[0]['user_user_id']);
                    $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                    $return['enter_member'] = $task_member['user_user_id'];
                    //查找默认打款金额
                    $setting_info = Model_Setting::getSetting($user_id);
                    $money = $setting_info['noactive_active_money'];
                    $return['promote_money'] = $money;
                }

            }
            //$return['task_member'] = $task_member;
            return $return;
        //}
    }

    //未激活的人的第九层级，若上面没有九层，就给系统设置的最高等级的默认会员打
    /**
     * @param $user_id int  当前网站所属ID
     * @param $user_user_id int  当前会员ID
     */
    public function getNine($user_id,$user_user_id){
        //获取系统当前最大等级
        $max_grade = Model_Grade::getGradeCount($user_id);
        //当前用户的上级
        $member = Model_Member::getMemberByUser($user_user_id);
        $higher_id = $member[0]['higher_id'];
        $i = 1;
        $member_info = array();
        while($i <= $max_grade){
            $info = $this->nineUser($higher_id);
            if(!$info){
                break;
            }
            $member_info = $info['member_info'];
            $higher_id = $info['higher_id'];
            $i++;
        }

        $grade = Model_Grade::getMaximumGrade($user_id);
        $level = $i-1;
        $return = array();
        $return['promote_type']     = 2;
        $return['task_grade']       = 2;
        $return['promote_money']    = $grade[0]['promote_money'];
        $return['status_title']     = '待打款';
        if($level == $max_grade){
            $return['out_member'] = $user_user_id;
            $return['enter_member'] = $member_info['user_user_id'];
            $user_info = Model_User::getUserById($member_info['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
        }else{
            //var_dump($grade);exit;
            //没有查到第九层，则找默认的人
            if($grade['user_user_id']){
                $return['out_member']   = $user_user_id;
                $return['enter_member'] = $grade['user_user_id'];
                $user_info = Model_User::getUserById($grade['user_user_id']);
                $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                //查找默认打款金额
                $setting_info = Model_Setting::getSetting($user_id);
                $money = $setting_info['noactive_active_money'];
                $return['promote_money'] = $money;
            }else{
                return false;
            }
        }
        return $return;
    }


    public function nineUser($higher_id){
        $member = Model_Member::getMemberByUser($higher_id);
        if($member){
            return array('higher_id'=>$member[0]['higher_id'],'member_info'=>$member[0]);
        }else{
            return false;
        }
    }

}
