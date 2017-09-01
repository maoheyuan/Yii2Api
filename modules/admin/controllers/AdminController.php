<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin;
use yii\helpers\ArrayHelper;
use app\helper\Helper;
use app\helper\page;

class AdminController extends Controller
{
    public  $layout = 'main';

    public  $pageTheme="";
    public function init(){
        $this->enableCsrfValidation = false;
        $this->pageTheme=Yii::$app->params['pageTheme'];
    }
    public function actionIndex()
    {
        $getData=Yii::$app->request->get();
        $startTime=Yii::$app->request->get("startTime");
        $endTime=Yii::$app->request->get("endTime");
        $key=Yii::$app->request->get("key","");
        $content=Yii::$app->request->get("content","");
        $pageLimit= Yii::$app->request->get("limit");
        if($pageLimit=="") {
            $pageLimit=20;
        }
        $model=Admin::find();
        if($startTime){
            $model->andWhere([">=","admin_add_time",strtotime($startTime)]);
        }
        if($endTime){
            $model->andWhere(["<=","admin_add_time",strtotime($endTime)]);
        }
        if($content){
            if($key=="admin_id"){
                $model->where(["admin_id"=>$content]);
            }
            else{
                $model->where(["like","admin_name",$content]);
            }
        }
        $count=$model->count();
        $page       = new page($count,$pageLimit);
        if($this->pageTheme!=""){
            $page->setConfig('theme',$this->pageTheme);
        }
        $show       = $page->show();
        $goodsList =$model->offset($page->firstRow)->limit($page->listRows)->asArray()->all();
        //echo $model->createCommand()->getRawSql();
        return $this->render("index", ["goodsList"=>$goodsList,"page"=>$show,"request"=>$getData]);
    }

    public function actionAdd()
    {
        if(Yii::$app->request->isPost){
            $model=new Admin();
            $post=Yii::$app->request->post();
            $result=$model->admin_add($post);
            if($result){
                $returnData=Helper::returnData(true,["id"=>$result],"新增成功!");
            }
            else{
                $error=Helper::getFirstError($model);
                $returnData=Helper::returnData(false,$error,"新增成功!");
            }
        }
        else{
            return $this->render("add");
        }
    }


    public function  actionUpdate($admin_id){
        $model=new Admin();
        $post=Yii::$app->request->post();
        $post["admin_id"]=$admin_id;
        $result=$model->admin_edit($post);
        if($result){

            $returnData=Helper::returnData(true,["id"=>$result],"修改成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"修改失败!");
        }
        return $returnData;
    }

    public  function  actionView($admin_id){
        $model=new Admin();
        $result=$model->get_view_by_id($admin_id);
        $result=ArrayHelper::toArray($result);
        if($result){
            $returnData=Helper::returnData(true,$result,"查找成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"查找失败!");
        }
        return $returnData;
    }
    public function actionDelete($admin_id){
        $model=new Admin();
        $result=$model->goods_delete($admin_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }




}
