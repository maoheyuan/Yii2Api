<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
class Member extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%member}}";
    }

    //CREATE TABLE `mhy_member` (
    //`member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员id',
    //`member_name` varchar(50) NOT NULL COMMENT '会员名称',
    //`member_truename` varchar(20) DEFAULT NULL COMMENT '真实姓名',
    //`member_avatar` varchar(50) DEFAULT NULL COMMENT '会员头像',
    //`member_sex` tinyint(1) DEFAULT NULL COMMENT '会员性别 1男 2女',
    //`member_birthday` date DEFAULT NULL COMMENT '生日',
    //`member_passwd` varchar(32) NOT NULL COMMENT '会员密码',
    //`member_mobile` varchar(11) DEFAULT '' COMMENT '会员手机号',
    //`member_email` varchar(100) NOT NULL COMMENT '会员邮箱',
    //`member_qq` varchar(100) DEFAULT NULL COMMENT 'qq',
    //`member_time` varchar(10) NOT NULL COMMENT '会员注册时间',
    //`member_points` int(11) NOT NULL DEFAULT '0' COMMENT '会员积分',
    //`member_state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '会员的开启状态 1为开启 0为关闭',
    //`member_areaid` int(11) DEFAULT NULL COMMENT '地区ID',
    //`member_cityid` int(11) DEFAULT NULL COMMENT '城市ID',
    //`member_provinceid` int(11) DEFAULT NULL COMMENT '省份ID',
    //`member_areainfo` varchar(255) DEFAULT NULL COMMENT '地区内容',
    //`member_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员金额',
    //PRIMARY KEY (`member_id`),
    //KEY `member_name` (`member_name`) USING BTREE
    //) ENGINE=MyISAM AUTO_INCREMENT=359 DEFAULT CHARSET=utf8 COMMENT='会员表';

    public function rules()
    {
        return [
            ['member_id', 'required', 'message' => '会员ID不能为空',"on"=>["member_edit"]],
            ['member_name', 'required', 'message' => '会员名称不能为空',"on"=>["member_edit","member_add"]],
            ['member_truename','required',"message"=>'真实姓名不能为空',"on"=>["member_edit","member_add"]],
            ['member_avatar','required',"message"=>'会员头像不能为空',"on"=>["member_edit","member_add"]],
            ['member_sex','required',"message"=>'性别不能为空',"on"=>["member_edit","member_add"]],
            ['member_passwd','required',"message"=>'密码不能为空',"on"=>["member_edit","member_add"]],
            ['member_rpasswd','required',"message"=>'确认密码不能为空',"on"=>["member_edit","member_add"]],
            ['member_mobile','required',"message"=>'会员手机号不能为空',"on"=>["member_edit","member_add"]],
            ['member_qq','required',"message"=>'qq不能为空',"on"=>["member_edit","member_add"]],
            ['member_birthday','required',"message"=>'生日不能为空',"on"=>["member_edit","member_add"]],
            ['member_time','required',"message"=>'member_time不能为空',"on"=>["member_add"]],
            ['member_state','required',"message"=>'会员状态不能为空',"on"=>["member_edit","member_add"]],
            ['member_areaid','required',"message"=>'地区ID不能为空',"on"=>["member_edit","member_add"]],
            ['member_cityid','required',"message"=>'城市ID不能为空',"on"=>["member_edit","member_add"]],
            ['member_provinceid','required',"message"=>'省份ID不能为空',"on"=>["member_edit","member_add"]],
            ['member_areainfo','required',"message"=>'地区内容不能为空',"on"=>["member_edit","member_add"]],
            ['member_money','required',"message"=>'会员金额不能为空',"on"=>["member_edit","member_add"]],

        ];
    }


    public function member_add($data, $scenario = 'member_add')
    {
        $this->scenario = $scenario;
        if ($this->load($data) && $this->validate()) {
            $this->member_time = time();
            if ($this->save(false)) {
                return true;
            }
            return false;
        }
        return false;
    }


    public  function  member_edit($data, $scenario = 'member_edit'){
        $this->scenario = $scenario;

        $this->scenario = "changepass";
        if ($this->load($data) && $this->validate()) {
            return (bool)$this->updateAll(
                [
                    'member_name'       =>  $data["member_name"],
                    'member_truename'   =>  $data["member_truename"],
                    'member_avatar'     =>  $data["member_avatar"],
                    'member_sex'        =>  $data["member_sex"],
                    'member_passwd'     =>  $data["member_passwd"],
                    'member_mobile'     =>  $data["member_mobile"],
                    'member_qq'         =>  $data["member_qq"],
                    'member_birthday'   =>  $data["member_birthday"],
                    'member_time'       =>  $data["member_time"],
                    'member_state'      =>  $data["member_state"],
                    'member_areaid'     =>  $data["member_areaid"],
                    'member_cityid'     =>  $data["member_cityid"],
                    'member_provinceid' =>  $data["member_provinceid"],
                    'member_areainfo'   =>  $data["member_areainfo"],
                    'member_money'      =>  $data["member_money"]

                ],
                'member_id = :member_id',
                [':member_id' => $this->member_id]
            );
        }
        return false;

    }
}
