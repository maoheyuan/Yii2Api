<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Member;
use yii\helpers\ArrayHelper;

class GoodsController extends Controller
{

    public function init(){
        $this->enableCsrfValidation = false;
    }

    public function actionIndex()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $page= Yii::$app->request->get("page");
        $page_limit= Yii::$app->request->get("page_limit");
        $goodsCount=Goods::find()->count();
        $goodsList =  Goods::find()->offset($page*$page_limit)->limit($page_limit)->asArray()->all();
        return [
            'code'=>true,
            'count'=>$goodsCount,
            "data"=>$goodsList
        ];
    }

    public function actionCreate()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $returnData=array();
        $model=new Goods();
        $post=Yii::$app->request->post();
        $result=$model->goods_add($post);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="新增成功!";
            $returnData["data"]=["id"=>$result];
        }
        else{
            $error=$this->getFirstError($model);
            $returnData["code"]=false;
            $returnData["tip"]="新增失败!";
            $returnData["data"]=$error;
        }
        return $returnData;

    }


    public function  actionUpdate($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Goods();
        $post=Yii::$app->request->post();
        $post["member_id"]=$member_id;
        $result=$model->goods_edit($post);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="修改成功!";
            $returnData["data"]=["id"=>$result];
        }
        else{
            $returnData["code"]=false;
            $returnData["tip"]="修改失败!";
            $returnData["data"]=[];
        }
        return $returnData;
    }

    public  function  actionView($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Goods();
        $result=$model->get_view_by_id($member_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="查找成功!";
            $returnData["data"]=$result;
        }
        else{
            $returnData["code"]=false;
            $returnData["tip"]="查找失败!";
            $returnData["data"]=[];
        }
        return $returnData;
    }


    public function actionDelete($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Goods();
        $result=$model->goods_delete($member_id);
        if($result){
            $returnData["code"]=true;
            $returnData["tip"]="删除成功!";
            $returnData["data"]=["id"=>$result];
        }
        else{
            $returnData["code"]=false;
            $returnData["tip"]="删除失败!";
            $returnData["data"]=[];
        }
        return $returnData;
    }

    protected  function  getFirstError($model){

      return  array_values($model->getFirstErrors())[0];
    }


}
