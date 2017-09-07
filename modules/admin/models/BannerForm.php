<?php

namespace app\modules\admin\models;

use \yii\base\Model;
class BannerForm extends Model
{
    public $banner_id;
    public $banner_name;
    public $banner_image;
    public $banner_status;
    public $banner_category;
    public $banner_start_time;
    public $banner_end_time;
    public $banner_add_time;
    public $banner_edit_time;
    public $banner_sort;
    public function rules(){

        return [
            ["banner_id","required","message"=>"编号不能为空"],
            ["banner_name","required","message"=>"名称不能为空"],
            ["banner_image","required","message"=>"图片不能为空"],
            ["banner_status","required","message"=>"状态不能为空"],
            ["banner_category","required","message"=>"所属分类不能为空"],
            ["banner_start_time","required","message"=>"有效开始时间不能为空"],
            ["banner_end_time","required","message"=>"有效结束时间不能为空"],
            ["banner_add_time","required","message"=>"新增时间不能为空"],
            ["banner_edit_time","required","message"=>"修改时间不能为空"],
            ["banner_sort","required","message"=>"排序不能为空"]
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
}
