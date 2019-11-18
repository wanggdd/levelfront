<?php

namespace Model\WebPlugin;

class Model_Grade extends \Model
{
    /**
     * 通过grade_id获取等级信息
     * @param int $id
     * @return mixed
     */
    public static function getGradeByGrade($id = 0){
        if(!$id)
            return false;

        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('id='.$id);
        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    public static function getGrade($fileds = array()){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        if($fileds){
            foreach($fileds as $key=>$item){
                $obj->addAndWhere($key.'='.$item);
            }
        }

        return $obj->query(false);
    }
    /**
     * 根据会员id，查找是否是初始用户
     * @param $user_id 网站所属人ID
     * @param $user_user_id 会员ID
     * @return mixed
     */
    public static function getInfoByUser($user_id,$user_user_id){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('user_id='.$user_id.' and user_user_id='.$user_user_id);
        $result = $obj->query(false);
        if($result)
            return $result[0];
        return false;
    }

    //获取最高等级
    public static function getMaximumGrade($user_id,$type = 'desc'){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('user_id='.$user_id);
        $obj->addOrderBy('grade',$type);
        $obj->setLimiter(0,1);
        $result = $obj->query(false);

        return $result;
    }

    public static function upUserGrade($field,$value,$uid){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));

        return $obj->update('member s',[$field=>$value],'user_user_id='.$uid);
    }

    public static function getNextGrade($user_id,$current_grade){
        $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
        $obj->from('grade s');
        $obj->addAndWhere('user_id='.$user_id.' and grade>'.$current_grade);
        $obj->addOrderBy('grade','asc');
        $obj->setLimiter(0,1);
        $result = $obj->query(false);

        return $result;
    }

    /**
     * 判断是否需要晋升，并在需要时晋升
     * @param $user_id 网站所属人ID
     * @param $user_user_id 会员ID
     * @return mixed 1代表成功，>1值都代表失败
     */
    public static function promote($user_id,$user_user_id){
        //获取会员当前等级
        $member_info = Model_Member::getMemberByUser($user_user_id);
            /*未激活用户不参与晋升*/
        if($member_info[0]['status'] != 2)
            return 2;
        if($member_info[0]['grade'] == 0){
            $current_grade = 0;
        }else{
            $grade_info = self::getGradeByGrade($member_info[0]['grade']);
            /*说明此会员所对应的等级已被删除或处理，这时不做处理*/
            if(!$grade_info)
                return 3;
            $current_grade = $grade_info['grade'];
        }

        //判断当前会员是否是系统初始用户（是的话不需要晋升）
        $init_info = self::getInfoByUser($user_id,$user_user_id);
        if($init_info){
            return 4;
        }

        //判断当前会员是否已经是最高等级
        $max_grade = self::getMaximumGrade($user_id);
            /*此数据没有时，说明当前后台还未设置等级*/
        if(!$max_grade)
            return 5;
            /*相等时说明已经是最高等级，不需要晋升*/
        if($current_grade == $max_grade['grade'])
            return 6;

        //判断是否达到了晋升条件并晋升
            /*当前没有等级时，晋升到最低等级；有等级时，晋升到当前等级+1*/
        if($current_grade == 0){
            $up_grade = self::getMaximumGrade($user_id,'asc');
        }else{
            $obj = \Factory::N('DBHelper', \Ebase::getDb('DB_Pluginl'));
            $obj->from('grade s');
            $obj->addAndWhere('user_id='.$user_id.' and grade>'.$current_grade);
            $obj->addOrderBy('grade','asc');
            $obj->setLimiter(0,1);
            $up_grade = $obj->query(false);
        }
            /*获取当前会员的下级总数*/
        $lower_count = Model_Member::getLowerCount($user_user_id);
            /*晋升数量规则 1:大于等于  2:等于*/
        if($up_grade['promote_lower_type'] == 1){
            if($lower_count >= $up_grade['promote_lower_num']){
                //晋升
                self::upUserGrade('grade',$up_grade['id'],$user_user_id);
                return 1;
            }
        }
        if($up_grade['promote_lower_type'] == 2){
            if($lower_count = $up_grade['promote_lower_num']){
                //晋升
                self::upUserGrade('grade',$up_grade['id'],$user_user_id);
                return 1;
            }
        }
        return 10;
    }


}