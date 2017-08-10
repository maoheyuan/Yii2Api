<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
class Order extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%admin}}";
    }

    /*CREATE TABLE `mhy_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '订单编号',
  `order_member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员编号',
  `order_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单价格（商品金额+运费）',
  `order_pay_type` int(11) NOT NULL DEFAULT '0' COMMENT '支付类型（1支付包，2微信, 3货到付款）',
  `order_pay_status` smallint(6) NOT NULL DEFAULT '0' COMMENT '支付状态（1等待支付，2以支付，3支付失败）',
  `order_pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订单状态（1未支付2取消 3已支付 4已分拣 5已配送 6已完成）',
  `order_add_time` int(11) NOT NULL DEFAULT '0' COMMENT '新增时间',
  `order_preferential_privilege` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠价格',
  `order_coupon_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用优惠券金额',
  `order_account_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '使用账户金额',
  `order_pay_type_money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付类型金额',
  `order_freight` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `order_return_status` tinyint(2) DEFAULT '0' COMMENT '退货状态（0：未退货 1：部分退货 2：完全退货）',
  `order_distribution_start_time_period` int(11) NOT NULL DEFAULT '0' COMMENT '配送开始时间段',
  `order_distribution_end_time_period` int(11) NOT NULL DEFAULT '0' COMMENT '配送开始时间段',
  `order_transaction_id` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '支付流水号',
  `order_out_trade_no` char(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '支付客户单号',
  `order_notes` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '客户下单备注信息',
  `order_consignee_mobile` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '收货人手机号',
  `order_consignee_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `order_consignee_province_id` int(11) DEFAULT '0' COMMENT '收货人所在省',
  `order_consignee_city_id` int(11) DEFAULT '0' COMMENT '收货人所在市',
  `order_consignee_area_id` int(11) DEFAULT '0' COMMENT '收货人所在区',
  `order_consignee_cell_id` int(11) DEFAULT '0' COMMENT '收货人小区',
  `order_consignee_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '订单收货人地址',
  `order_delivery_time` int(11) NOT NULL DEFAULT '0' COMMENT '配送时间',
  PRIMARY KEY (`order_id`),
  KEY `orderSn` (`order_sn`(191)) USING BTREE,
  KEY `memberId` (`order_member_id`) USING BTREE,
  KEY `status` (`order_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=329245 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单表';*/
    public function rules()
    {
        return [
            ['order_id', 'required', 'message' => '订单ID不能为空',"on"=>["admin_edit","admin_delete"]],
            ['order_sn', 'required', 'message' => '订单编号不能为空',"on"=>["admin_edit","admin_add","order_delete_by_ordresn"]],
            ['order_member_id','required',"message"=>'会员编号不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_money','required',"message"=>'订单价格不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_pay_type','required',"message"=>'支付类型不能为空',"on"=>["admin_add"]],
            ['order_pay_status','required',"message"=>'支付状态不能为空',"on"=>["admin_edit"]],
            ['order_pay_time', 'required', 'message' => '支付时间不能为空',"on"=>["admin_edit","admin_delete"]],
            ['order_status', 'required', 'message' => '订单状态不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_add_time','required',"message"=>'新增时间不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_preferential_privilege','required',"message"=>'优惠价格不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_coupon_money','required',"message"=>'优惠券金额不能为空',"on"=>["admin_add"]],
            ['order_account_money','required',"message"=>'账户金额不能为空',"on"=>["admin_edit"]],
            ['order_pay_type_money', 'required', 'message' => '支付类型金额不能为空',"on"=>["admin_edit","admin_delete"]],
            ['order_freight', 'required', 'message' => '运费不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_return_status','required',"message"=>'退货状态不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_distribution_start_time_period','required',"message"=>'配送开始时间段不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_distribution_end_time_period','required',"message"=>'配送结束时间段不能为空',"on"=>["admin_add"]],
            ['order_transaction_id','required',"message"=>'支付流水号不能为空',"on"=>["admin_edit"]],
            ['order_out_trade_no', 'required', 'message' => '支付客户单号不能为空',"on"=>["admin_edit","admin_delete"]],
            ['order_notes', 'required', 'message' => '备注信息不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_consignee_mobile','required',"message"=>'收货人手机号不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_consignee_name','required',"message"=>'收货人姓名不能为空',"on"=>["admin_edit","admin_add"]],
            ['order_consignee_province_id','required',"message"=>'收货人所在省',"on"=>["admin_add"]],
            ['order_consignee_city_id','required',"message"=>'收货人所在市',"on"=>["admin_edit"]],
            ['order_consignee_area_id','required',"message"=>'收货人所在区',"on"=>["admin_edit"]],
            ['order_consignee_cell_id','required',"message"=>'收货人小区不能为空',"on"=>["admin_edit"]],
            ['order_consignee_address','required',"message"=>'订单收货人地址不能为空',"on"=>["admin_edit"]],
            ['order_delivery_time','required',"message"=>'配送时间不能为空',"on"=>["admin_edit"]],
        ];
    }


    public function order_add($data=array(), $scenario ='order_add')
    {
        $this->scenario = $scenario;
        $data["order_add_time"]=time();
        $this->load($data,"");
        if ($this->validate()){
            $result=$this->save(false);
            if ($result) {
                return $this->order_id;
            }
            return false;
        }
        return false;
    }


    public  function  order_edit($data, $scenario = 'order_edit'){
        $this->scenario = $scenario;
        $data["order_edit_time"]=time();
        $this->load($data,"");
        if ($this->validate()) {
            return (bool)$this->updateAll(
                [
                    'order_sn'                          =>  $data["order_sn"],
                    'order_member_id'                   =>  $data["order_member_id"],
                    'order_money'                       =>  $data["order_money"],
                    'order_pay_type'                    =>  $data["order_pay_type"],
                    'order_pay_status'                  =>  $data["order_pay_status"],
                    'order_pay_time'                    =>  $data["order_pay_time"],
                    'order_status'                      =>  $data["order_status"],
                    'order_add_time'                    =>  $data["order_add_time"],
                    'order_preferential_privilege'      =>  $data["order_preferential_privilege"],
                    'order_coupon_money'                =>  $data["order_coupon_money"],
                    'order_account_money'               =>  $data["order_account_money"],
                    'order_pay_type_money'              =>  $data["order_pay_type_money"],
                    'order_freight'                     =>  $data["order_freight"],
                    'order_return_status'               =>  $data["order_return_status"],
                    'order_distribution_start_time_period' =>  $data["order_distribution_start_time_period"],
                    'order_distribution_end_time_period'   =>  $data["order_distribution_end_time_period"],
                    'order_transaction_id'              =>  $data["order_transaction_id"],
                    'order_out_trade_no'                =>  $data["order_out_trade_no"],
                    'order_notes'                       =>  $data["order_notes"],
                    'order_consignee_mobile'            =>  $data["order_consignee_mobile"],
                    'order_consignee_name'              =>  $data["order_consignee_name"],
                    'order_distribution_end_time_period'=>  $data["order_distribution_end_time_period"],
                    'order_consignee_province_id'       =>  $data["order_consignee_province_id"],
                    'order_consignee_city_id'           =>  $data["order_consignee_city_id"],
                    'order_consignee_area_id'           =>  $data["order_consignee_area_id"],
                    'order_consignee_cell_id'           =>  $data["order_consignee_cell_id"],
                    'order_consignee_address'           =>  $data["order_consignee_address"],
                    'order_delivery_time'               =>  $data["order_delivery_time"],
                ],
                'order_id = :order_id',
                [':order_id' => $this->order_id]
            );
        }
        return false;
    }


    public  function  order_delete($order_id){

        $this->scenario="order_delete";
        $this->load($data["order_id"]=$order_id,"");
        if($this->validate()) {
            if ($this->delete($order_id)) {
                return true;
            }
        }
        return false;

    }


    public  function  order_delete_by_ordresn($order_sn){

        $this->scenario="order_delete_by_ordresn";
        $this->load($data["order_sn"]=$order_sn,"");
        if($this->validate()) {
            if ($this->where(["order_sn",$order_sn])->delete()) {
                return true;
            }
        }
        return false;

    }

    public  function  get_view_by_id($order_id){
       return $this->findOne($order_id);
    }
}
