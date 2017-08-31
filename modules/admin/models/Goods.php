<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
class Goods extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%goods}}";
    }

    /*CREATE TABLE `mhy_goods` (
    `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品索引id',
    `category_id` int(10) unsigned NOT NULL COMMENT '商品分类id',
    `goods_name` varchar(200) NOT NULL COMMENT '商品名称',
    `spec_name` varchar(255) NOT NULL DEFAULT '' COMMENT '规格名称',
    `goods_spec` text COMMENT '商品规格',
    `goods_image` varchar(100) NOT NULL COMMENT '商品默认封面图片',
    `goods_image_more` text COMMENT '商品多图',
    `goods_serial` varchar(50) NOT NULL DEFAULT '' COMMENT '商品货号',
    `goods_state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品状态，0开启，1违规下架',
    `goods_commend` tinyint(1) NOT NULL COMMENT '商品推荐 1 首页 2分类页',
    `goods_body` text NOT NULL COMMENT '商品详细内容',
    `goods_starttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布开始时间',
    `goods_endtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布结束时间',
    `goods_close_reason` varchar(255) NOT NULL DEFAULT '0' COMMENT '商品违规下架原因',
    `goods_add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品添加时间',
    `goods_edit_time` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
    `goods_sort` int(11) NOT NULL DEFAULT '10' COMMENT '排序',
    PRIMARY KEY (`goods_id`),
    KEY `gc_id` (`category_id`) USING BTREE,
    KEY `goods_starttime` (`goods_starttime`) USING BTREE
    ) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COMMENT='商品表';*/
    public function rules()
    {
        return [
            ['goods_id', 'required', 'message' => '商品索引ID不能为空',"on"=>["goods_edit","goods_delete"]],

            ['category_id', 'required', 'message' => '商品分类id不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_name','required',"message"=>'商品名称不能为空',"on"=>["goods_edit","goods_add"]],
            ['spec_name','required',"message"=>'规格名称不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_image','required',"message"=>'默认封面图片不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_image_more','required',"message"=>'商品货号不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_serial','required',"message"=>'商品货号不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_state','required',"message"=>'商品详细内容不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_commend','required',"message"=>'商品推荐不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_body','required',"message"=>'member_time不能为空',"on"=>["goods_add"]],
            ['goods_starttime','required',"message"=>'发布开始时间不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_endtime','required',"message"=>'发布结束时间不能为空',"on"=>["goods_edit","goods_add"]],
            ['goods_add_time','required',"message"=>'添加时间不能为空',"on"=>["goods_add"]],
            ['goods_edit_time','required',"message"=>'修改时间不能为空',"on"=>["goods_edit"]],
            ['goods_sort','required',"message"=>'排序不能为空',"on"=>["goods_edit","goods_add"]]

        ];
    }


    public function goods_add($data=array(), $scenario ='goods_add')
    {
        $this->scenario = $scenario;
        $data["goods_add_time"]=time();
        $this->load($data,"");
        if ($this->validate()){
            $this->goods_add_time = time();
            $result=$this->save(false);
            if ($result) {
                return $this->goods_id;
            }
            return false;
        }
        return false;
    }


    public  function  goods_edit($data, $scenario = 'goods_edit'){
        $this->scenario = $scenario;
        $data["goods_edit_time"]=time();
        $this->load($data,"");
        if ($this->validate()) {
            return (bool)$this->updateAll(
                [
                    'category_id'       =>  $data["category_id"],
                    'goods_name'   =>  $data["goods_name"],
                    'spec_name'     =>  $data["spec_name"],
                    'goods_spec'        =>  $data["goods_spec"],
                    'goods_image'     =>  $data["goods_image"],
                    'goods_image_more'     =>  $data["goods_image_more"],
                    'goods_serial'         =>  $data["goods_serial"],
                    'goods_state'   =>  $data["goods_state"],
                    'goods_commend'       =>  $data["goods_commend"],
                    'goods_body'      =>  $data["goods_body"],
                    'goods_starttime'     =>  $data["goods_starttime"],
                    'goods_endtime'     =>  $data["goods_endtime"],
                    'goods_close_reason' =>  $data["goods_close_reason"],
                    'goods_add_time'   =>  $data["goods_add_time"],
                    'goods_edit_time'      =>  $data["goods_edit_time"],
                    'goods_sort'   =>  $data["goods_sort"]
                ],
                'goods_id = :goods_id',
                [':goods_id' => $this->goods_id]
            );
        }
        return false;
    }


    public  function  goods_delete($goods_id){

        $this->scenario="goods_delete";
        $this->load($data["goods_id"]=$goods_id,"");
        if($this->validate()) {
            if ($this->delete($goods_id)) {
                return true;
            }
        }
        return false;

    }

    public  function  get_view_by_id($goods_id){
       return $this->findOne($goods_id);
    }
}
