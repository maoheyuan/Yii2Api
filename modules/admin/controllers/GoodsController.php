<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use app\modules\admin\models\Goods;
use yii\helpers\ArrayHelper;
use app\helper\Helper;

class GoodsController extends Controller
{

    public function init(){
        $this->enableCsrfValidation = false;
       /* Yii::$app->response->format=Response::FORMAT_JSON;*/
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
        $model=Goods::find();
        if($startTime){
            $model->andWhere([">=","goods_add_time",strtotime($startTime)]);
        }
        if($endTime){
            $model->andWhere(["<=","goods_add_time",strtotime($endTime)]);
        }
        if($content){
            if($key=="goods_id"){
                $model->where(["goods_id"=>$content]);
            }
            else{
                $model->where(["like","goods_name",$content]);
            }
        }
        $count=$model->count();
        $pageSize = Yii::$app->params['pageSize']['banner'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $goodsList = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("index", ['pager' => $pager, 'goodsList' => $goodsList]);
    }

    public function actionCreate()
    {

        $returnData=array();
        $model=new Goods();
        $post=Yii::$app->request->post();
        $result=$model->goods_add($post);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"新增成功!");
        }
        else{
            $error=Helper::getFirstError($model);
            $returnData=Helper::returnData(false,$error,"新增成功!");
        }
        return $returnData;

    }


    public function  actionUpdate($member_id){
        $model=new Goods();
        $post=Yii::$app->request->post();
        $post["member_id"]=$member_id;
        $result=$model->goods_edit($post);
        if($result){

            $returnData=Helper::returnData(true,["id"=>$result],"修改成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"修改失败!");
        }
        return $returnData;
    }

    public  function  actionView($member_id){
        $model=new Goods();
        $result=$model->get_view_by_id($member_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData=Helper::returnData(true,$result,"查找成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"查找失败!");
        }
        return $returnData;
    }
    public function actionDelete($member_id){
        $model=new Goods();
        $result=$model->goods_delete($member_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }

    public  function  actionSetStatus(){

        $model=new Goods();

        $status=Yii::$app->request->get("status",0);

        if($model->setStatus($status)){


            
        }

    }

}
