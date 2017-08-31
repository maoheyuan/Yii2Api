<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
class Banner extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%banner}}";
    }


    /*CREATE TABLE `mhy_banner` (
    `banner_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
    `banner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
    `banner_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片',
    `banner_status` int(11) NOT NULL DEFAULT '1' COMMENT '状态 启用1 禁用2',
    `banner_category` int(11) DEFAULT '0' COMMENT '所属产品分类',
    `banner_start_time` int(11) DEFAULT '0' COMMENT '有效开始时间',
    `banner_end_time` int(11) DEFAULT '0' COMMENT '有效结束时间',
    `banner_add_time` int(11) DEFAULT '0' COMMENT '新增时间',
    `banner_edit_time` int(11) DEFAULT '0' COMMENT '修改时间',
    `banner_sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
    PRIMARY KEY (`banner_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='广告位管理表';*/

    public function rules()
    {
        return [
            ['banner_id', 'required', 'message' => '编号不能为空',"on"=>["banner_edit","banner_delete"]],
            ['banner_name', 'required', 'message' => '名称不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_image','required',"message"=>'图片不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_status','required',"message"=>'状态不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_category','required',"message"=>'所属产品分类不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_start_time','required',"message"=>'有效开始时间不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_end_time','required',"message"=>'有效结束时间不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_add_time','required',"message"=>'新增时间不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_edit_time','required',"message"=>'修改时间不能为空',"on"=>["banner_edit","banner_add"]],
            ['banner_sort','required',"message"=>'排序不能为空',"on"=>["banner_add"]]

        ];
    }


    public function banner_add($data=array(), $scenario ='banner_add')
    {
        $this->scenario = $scenario;
        $this->load($data,"");
        if ($this->validate()){
            $this->banner_add_time = time();
            $result=$this->save(false);
            if ($result) {
                return $this->banner_id;
            }
            return false;
        }
        return false;
    }


    public  function  banner_edit($data, $scenario = 'banner_edit'){
        $this->scenario = $scenario;

        $this->load($data,"");
        if ($this->validate()) {
            return (bool)$this->updateAll(
                [
                    'banner_id'         =>  $data["banner_id"],
                    'banner_name'       =>  $data["banner_name"],
                    'banner_image'      =>  $data["banner_image"],
                    'banner_status'     =>  $data["banner_status"],
                    'banner_category'   =>  $data["banner_category"],
                    'banner_start_time' =>  $data["banner_start_time"],
                    'banner_end_time'   =>  $data["banner_end_time"],
                    'banner_add_time'   =>  $data["banner_add_time"],
                    'banner_edit_time'  =>  $data["banner_edit_time"],
                    'banner_sort'       =>  $data["banner_sort"]
                ],
                'banner_id = :banner_id',
                [':banner_id' => $this->banner_id]
            );
        }
        return false;
    }


    public  function  banner_delete($banner_id){

        $this->scenario="banner_delete";
        $this->load($data["banner_id"]=$banner_id,"");
        if($this->validate()) {

            if ($this->delete($banner_id)) {
                return true;
            }
        }
        return false;

    }


    public  function  get_view_by_id($banner_id){
       return $this->findOne($banner_id);
    }
}
