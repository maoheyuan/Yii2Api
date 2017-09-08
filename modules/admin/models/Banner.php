<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;
class Banner extends ActiveRecord
{

    public function rules(){

        return [
            ["banner_id","required","message"=>"编号不能为空","on"=>["bannerEdit"]],
            ["banner_name","required","message"=>"名称不能为空","on"=>["bannerAdd","bannerEdit"]],
            ["banner_image","required","message"=>"图片不能为空","on"=>["bannerAdd","bannerEdit"]],
            ["banner_status","required","message"=>"状态不能为空","on"=>["bannerAdd","bannerEdit"]],
            ["banner_category","required","message"=>"所属分类不能为空","on"=>["bannerAdd","bannerEdit"]],
            ["banner_start_time","required","message"=>"有效开始时间不能为空","on"=>["bannerAdd","bannerEdit"]],
            ["banner_end_time","required","message"=>"有效结束时间不能为空","on"=>["bannerAdd","bannerEdit"]],
            ["banner_edit_time","required","message"=>"修改时间不能为空","on"=>["bannerEdit"]],
            ["banner_sort","required","message"=>"排序不能为空","on"=>["bannerAdd","bannerEdit"]]
        ];
    }

    public  function  attributeLabels(){
        return [
            "banner_id"=>"轮播图编号",
            "banner_name"=>"轮播图名称",
            "banner_image"=>"轮播图图片",
            "banner_status"=>"轮播图状态",
            "banner_category"=>"轮播图分类",
            "banner_start_time"=>"有效开始时间",
            "banner_end_time"=>"有效结束时间",
            "banner_add_time"=>"新增时间",
            "banner_edit_time"=>"修改时间",
            "banner_sort"=>"轮播图排序"
        ];
    }

    public static function tableName()
    {
        return "{{%banner}}";
    }

    public function bannerAdd($data=array())
    {
        $this->scenario="bannerAdd";
        if ($this->load($data)&&$this->validate()){
            $this->banner_add_time = time();
            if ($this->save(false)) {
                return $this->banner_id;
            }
            return false;
        }
        return false;
    }

    public  function  bannerEdit($data){
        if ($this->load($data)&&$this->validate()) {
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
                [':banner_id' => $data["banner_id"]]
            );
        }
        return false;
    }


    public  function  bannerDelete($banner_id){
        $data["Banner"]["banner_id"]=$banner_id;
        if($this->load($data)&&$this->validate()) {
            if ($this->delete()) {
                return true;
            }
        }
        return false;
    }

    public  function  getInfoById($banner_id){
       return $this->findOne($banner_id);
    }
}
