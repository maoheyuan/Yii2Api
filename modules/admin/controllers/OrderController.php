<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\data\Pagination;
use app\modules\admin\models\Order;
use app\modules\admin\models\OrderGoods;
use yii\helpers\ArrayHelper;
use app\helper\Helper;

class OrderController extends Controller
{

    public   $tablePrefix="";
    public function init(){
        $this->enableCsrfValidation = false;
     /*   Yii::$app->response->format=Response::FORMAT_JSON;*/
        $this->tablePrefix= Yii::$app->db->tablePrefix;
    }

    public function actionIndex()
    {

        $this->layout="main";
        $getData=Yii::$app->request->get();
        $startTime=Yii::$app->request->get("startTime","");
        $endTime=Yii::$app->request->get("endTime");
        $key=Yii::$app->request->get("key","");
        $content=Yii::$app->request->get("content","");
        $pageLimit=Yii::$app->request->get("limit","");
        $model=Order::find();
        if($startTime){
            $model->andWhere([">=","order_add_time",strtotime($startTime)]);
        }
        if($endTime){
            $model->andWhere(["<=","order_add_time",strtotime($endTime)]);
        }
        if($content){
            if($key=="order_id"){
                $model->where(["order_id"=>$content]);
            }
            else{
                $model->where(["like","order_sn",$content]);
            }
        }
        $count=$model->count();
        $pageSize = Yii::$app->params['pageSize']['banner'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        $orderList=array();

        $orderList = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("index", ['pager' => $pager, 'orderList' => $orderList]);

    }


    public  function actionGetOrderGoodsList(){

        $tablePrefix= Yii::$app->db->tablePrefix;
        $start_time=Yii::$app->request->get("start_time");
        $end_time=Yii::$app->request->get("end_time");
        $order_sn=Yii::$app->request->get("order_sn","");
        $page= Yii::$app->request->get("page",0);
        $page_limit= Yii::$app->request->get("page_limit",20);
        $orderModel= Order::find()
            ->join(" LEFT JOIN",$tablePrefix."order",$tablePrefix."order.order_sn=".$tablePrefix."order_goods.ogoods_order_sn")
            ->where(array());
        if($start_time){
            $orderModel->andWhere([">=",$tablePrefix."order.order_add_time",strtotime($start_time)]);
        }
        if($end_time){
            $orderModel->andWhere(["<=",$tablePrefix."order.order_add_time",strtotime($end_time)]);
        }
        if($order_sn){
            $orderModel->andWhere(["like","admin_name",$order_sn]);
        }
        $orderCount=$orderModel->count();
        $orderGoodsList =$orderModel->offset($page*$page_limit)->limit($page_limit)->asArray()->all();

        $createPage= Helper::create_page($orderCount,$page,$page_limit);
        return [
            'status'=>true,
            "prev_page"=>$createPage["prev_page"],
            "next_page"=>$createPage["next_page"],
            'count_page'=>$createPage["count_page"],
            'first_page'=>$createPage["first_page"],
            'last_page'=>$createPage["last_page"],
            "list"=>$orderGoodsList
        ];
    }

    public function actionCreate()
    {

        $tr = Yii::app()->db->beginTransaction();
        try {

            $post=Yii::$app->request->post();
            $orderModel=new Order();
            $orderData=$post;
            $orderGoodsList=$post["goodsList"];
            unset($orderData["goodsList"]);
            $orderAddResult=$orderModel->order_add($orderData);
            if(!$orderAddResult){
                $error=Helper::getFirstError($orderModel);
                E("订单新增失败!".$error);
            }
            $orderGoodsModel=new OrderGoods();
            foreach($orderGoodsList as $key=>$value){
                $orderGoodsAddResult=$orderGoodsModel->ogoods_add($value);
                if(!$orderGoodsAddResult){
                    $error=Helper::getFirstError($orderModel);
                    E("商品新增失败!".$error);
                }
            }
            $tr->commit();
            $returnData=Helper::returnData(true,[],"新增成功!");
        } catch (Exception $e) {
            $tr->rollBack();
            $returnData=Helper::returnData(false,$e->getMessage(),"新增成功!");

        }
        return $returnData;

    }


    public function  actionUpdate(){

        $tr = Yii::app()->db->beginTransaction();
        try{
            $post=Yii::$app->request->post();
            $orderModel=new Order();
            $orderData=$post;
            $orderGoodsList=$post["goodsList"];
            unset($orderData["goodsList"]);
            $orderAddResult=$orderModel->order_edit($orderData);
            if(!$orderAddResult){
                $error=Helper::getFirstError($orderModel);
                E("订单修改失败!".$error);
            }
            $orderGoodsModel=new OrderGoods();
            foreach($orderGoodsList as $key=>$value){
                $orderGoodsAddResult=$orderGoodsModel->ogoods_edit($value);
                if(!$orderGoodsAddResult){
                    $error=Helper::getFirstError($orderModel);
                    E("商品修改败!".$error);
                }
            }
            $tr->commit();
            $returnData=Helper::returnData(true,[],"修改成功!");
        }
        catch(Exception $e){

            $tr->rollBack();
            $returnData=Helper::returnData(false,$e->getMessage(),"修改失败!");
        }

        return $returnData;
    }

    public  function  actionView($order_id){
        $orderModel=new Order();
        $orderInfo=$orderModel->get_view_by_id($order_id);
        $orderInfo=ArrayHelper::toArray($orderInfo);
        if($orderInfo){

            $orderGoodsModel=new OrderGoods();
            $orderGoodsList=$orderGoodsModel->get_order_goods_list($orderInfo["orderSn"]);

            $orderGoodsList=ArrayHelper::toArray($orderGoodsList);
        }
        $orderInfo["order_goods_list"]=$orderGoodsList;
        if($orderInfo){
            $returnData=Helper::returnData(true,$orderInfo,"查找成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"查找失败!");
        }
        return $returnData;
    }

    public function actionDelete($order_sn){
        $tr=Yii::app()->db->beginTransaction();
        try{
            $orderModel=new Order();
            $result=$orderModel->order_delete_by_ordresn($order_sn);
            if(!$result){
                $error=Helper::getFirstError($orderModel);
                E("订单删除失败!".$error);
            }
            $orderGoodsModel=new OrderGoods();
            $result=$orderGoodsModel->ogoods_delete_by_ordersn($order_sn);
            if(!$result){
                $error=Helper::getFirstError($orderGoodsModel);
                E("订单商品删除失败!".$error);
            }
            $tr->commit();
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        catch(Exception $e){
            $tr->rollback();
            $returnData=Helper::returnData(false,[],"删除失败!".$e->getMessage());
        }
        return $returnData;
    }




}
