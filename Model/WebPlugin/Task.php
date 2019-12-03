<?php

//���������ͼ���
namespace Model\WebPlugin;

class Model_Task extends \Model
{
    //�Ѿ�������˵������б�
    /**
     * �Ȼ�ȡ��ǰ��ԱҪ�������ĵȼ�i,�ҵ�i�����(���ҵ�i����ˣ��м䲻�˳�)�����i��Ļ�Ա>=i���������i����˴�
     * ��û�е�i��ֱ�Ӹ���ߵȼ��ĳ�ʼ��Ա��
     * ���е�i�㣬ȴ��>=i��������������3��(������ֹͣ)��һֱ��3�㻹û�з��ϵģ������ߵȼ��ĳ�ʼ��Ա��
     * @param $user_id int  ��ǰ��վ����ID
     * @param $user_user_id int  ��ǰ��ԱID
     */
    public function getThree($user_id,$user_user_id){
        $return = array();
        $task_member = array();
        //�Ȼ�ȡ��ǰ��Ա�ĵȼ�
        $member = Model_Member::getMemberByUser($user_id,$user_user_id);
        if(!$member[0]['higher_id'])
            return $return;
        $current_grade = $member[0]['grade'];//����ֵ��grade������

        //��ȡ��ߵȼ�
        $max_grade = Model_Grade::getMaximumGrade($user_id,'desc');
        if($current_grade == $max_grade)//��ǰ����ߵȼ�ʱ������
            return $return;

        /* --------------�����߼�����������ֵ=�ȼ�����1-9�����м��޶ϲ��ǰ����е�-------------- */
        $current_info = Model_Grade::getGradeByGrade($current_grade,$user_id);
        $next_grade = Model_Grade::getNextGrade($user_id,$current_info['grade']);

        //������д��ڵ�ǰ�ȼ��ĵȼ����
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
        //�ҵ����ϲ��i��Ļ�Ա
        if($level == $next_grade['grade']){
            //�жϴ˻�Ա�Ƿ�>=��һ��
            if(in_array($member_info['grade'],$grade_ids)){
                $task_member = $member_info;
            }else{
                //��������3��
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
                            //����ߵȼ��ĳ�ʼ��Ա
                            $member4 = Model_Member::getMemberByUser($user_id,$max_grade['user_user_id']);
                            if(!$member4)
                                return $return;

                            $task_member = $member4[0];
                        }
                    }

                }
            }
        }else{
            //����ߵȼ��ĳ�ʼ��Ա
            $member4 = Model_Member::getMemberByUser($user_id,$max_grade['user_user_id']);
            if(!$member4)
                return $return;

            $task_member = $member4[0];
        }
        /* --------------�����߼�����������ֵ=�ȼ�ֵ��ǰ���½��е�-------------- */



        //���ϲ�3�㣬�Ƿ��еȼ����ڵ�ǰ�ȼ��Ļ�Ա
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

        //���һ�ȡ����user_id���û���
        if($task_member){
            $user_info = Model_User::getUserById($user_id,$task_member['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
            $return['enter_member'] = $task_member['user_user_id'];

            //�ȼ���Ϣ
            $last_grade = Model_Grade::getGradeByGrade($task_member['grade'],$user_id);
            $return['promote_money']    = $last_grade['promote_money'];
            $return['grade_title']      = '����'.$last_grade['title'].'����';
            $return['promote_type']     = 1;
            $return['out_member']       = $user_user_id;
            $return['task_grade']       = $last_grade['id'];
        }
        return $return;
    }

    //δ������˵ĵھŲ㼶��������û�оŲ㣬�͸�ϵͳ���õ���ߵȼ���Ĭ�ϻ�Ա��
    /**
     * @param $user_id int  ��ǰ��վ����ID
     * @param $user_user_id int  ��ǰ��ԱID
     */
    public function getNine($user_id,$user_user_id){
        //��ȡϵͳ��ǰ�ȼ��Ĳ���
        $max_grade = Model_Grade::getGradeCount($user_id);
        //��ǰ�û����ϼ�
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
        $return['status_title']     = '�����';
        if($level == $max_grade){
            $return['out_member'] = $user_user_id;
            $return['enter_member'] = $member_info['user_user_id'];
            $user_info = Model_User::getUserById($user_id,$member_info['user_user_id']);
            $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
            //��ȡ�ȼ���Ϣ
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
            //û�в鵽�ھŲ㣬����Ĭ�ϵ���
            $grade = Model_Grade::getMaximumGrade($user_id);
            if($grade['user_user_id']){
                $return['out_member']   = $user_user_id;
                $return['enter_member'] = $grade['user_user_id'];
                $user_info = Model_User::getUserById($user_id,$grade['user_user_id']);
                $return['nick_name'] = $user_info[0]['nick_name'] ? $user_info[0]['nick_name'] : $user_info[0]['user_name'];
                //����Ĭ�ϴ����
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
