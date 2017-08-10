<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
class OrderGoods extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%order_goods}}";
    }

    /*CREATE TABLE `mhy_order_goods` (
      `ogoods_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `ogoods_order_sn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '订单编号',
      `ogoods_goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
      `ogoods_goods_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '商品名称',
      `ogoods_goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
      `ogoods_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
      `ogoods_add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
      `ogoods_member_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '会员id',
      `ogoods_unit` char(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规格/单位',
      `ogoods_return_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '已退货数量',
      `ogoods__money` decimal(10,2) DEFAULT '0.00' COMMENT '活动优惠价格',
      `ogoods_real_pay_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品实际支付金额',
      `ogoods_buying_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '进货价',
      PRIMARY KEY (`ogoods_id`),
      KEY `orderSn` (`ogoods_order_sn`(191)) USING BTREE,
      KEY `memberId` (`ogoods_member_id`) USING BTREE,
      KEY `goodsId` (`ogoods_goods_id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=1136451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单商品表';*/
    public function rules()
    {
        return [
            ['ogoods_id', 'required', 'message' => '订单商品ID不能为空',"on"=>["ogoods_edit","ogoods_delete"]],
            ['ogoods_order_sn', 'required', 'message' => '订单编号不能为空',"on"=>["ogoods_edit","ogoods_add"]],
            ['ogoods_goods_id','required',"message"=>'商品id不能为空',"on"=>["ogoods_edit","ogoods_add"]],
            ['ogoods_goods_name','required',"message"=>'商品名称不能为空',"on"=>["ogoods_edit","ogoods_add"]],
            ['ogoods_goods_price','required',"message"=>'商品数量不能为空',"on"=>["ogoods_add"]],
            ['ogoods_num','required',"message"=>'修改时间不能为空',"on"=>["ogoods_edit"]],
            ['ogoods_add_time','required',"message"=>'下单时间不能为空',"on"=>["ogoods_edit","ogoods_add"]],
            ['ogoods_member_id','required',"message"=>'会员id不能为空',"on"=>["ogoods_edit","ogoods_add"]],
            ['ogoods_unit','required',"message"=>'规格/单位不能为空',"on"=>["ogoods_add"]],
            ['ogoods_return_num','required',"message"=>'已退货数量不能为空',"on"=>["ogoods_edit"]],
            ['ogoods__money','required',"message"=>'活动优惠价格不能为空',"on"=>["ogoods_edit","ogoods_add"]],
            ['ogoods_real_pay_money','required',"message"=>'商品实际支付金额不能为空',"on"=>["ogoods_edit","ogoods_add"]],
            ['ogoods_buying_price','required',"message"=>'进货价不能为空',"on"=>["ogoods_add"]],
        ];
    }


    public function ogoods_add($data=array(), $scenario ='ogoods_add')
    {
        $this->scenario = $scenario;
        $data["ogoods_add_time"]=time();
        $this->load($data,"");
        if ($this->validate()){
            $result=$this->save(false);
            if ($result) {
                return $this->ogoods_id;
            }
            return false;
        }
        return false;
    }


    public  function  ogoods_edit($data, $scenario = 'ogoods_edit'){
        $this->scenario = $scenario;
        $data["ogoods_edit_time"]=time();
        $this->load($data,"");
        if ($this->validate()) {
            return (bool)$this->updateAll(
                [
                    'ogoods_order_sn'   =>  $data["ogoods_order_sn"],
                    'ogoods_goods_id'     =>  $data["ogoods_goods_id"],
                    'ogoods_goods_name'         =>  $data["ogoods_goods_name"],
                    'ogoods_goods_price'       =>  $data["ogoods_goods_price"],
                    'ogoods_num'       =>  $data["ogoods_num"],
                    'ogoods_add_time'       =>  $data["ogoods_add_time"],
                    'ogoods_member_id'       =>  $data["ogoods_member_id"],
                    'ogoods_unit'       =>  $data["ogoods_unit"],
                    'ogoods_return_num'       =>  $data["ogoods_return_num"],
                    'ogoods__money'       =>  $data["ogoods__money"],
                    'ogoods_real_pay_money'       =>  $data["ogoods_real_pay_money"],
                    'ogoods_buying_price'       =>  $data["ogoods_buying_price"],
                ],
                'ogoods_id = :ogoods_id',
                [':ogoods_id' => $this->ogoods_id]
            );
        }
        return false;
    }


    public  function  ogoods_delete($ogoods_id){

        $this->scenario="ogoods_delete";
        $this->load($data["ogoods_id"]=$ogoods_id,"");
        if($this->validate()) {
            if ($this->delete($ogoods_id)) {
                return true;
            }
        }
        return false;

    }

    public  function  get_view_by_id($admin_id){
       return $this->findOne($admin_id);
    }
}
