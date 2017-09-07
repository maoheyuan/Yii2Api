<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use yii\helpers\ArrayHelper;
use app\helper\helper;
use yii\data\Pagination;
use app\modules\admin\models\Banner;
use app\modules\admin\models\BannerForm;
use app\modules\admin\models\Category;
class BannerController extends Controller
{

    public function actionIndex(){


        $this->layout="main";
        $getData=Yii::$app->request->get();
        $startTime=Yii::$app->request->get("startTime","");
        $endTime=Yii::$app->request->get("endTime");
        $key=Yii::$app->request->get("key","");
        $content=Yii::$app->request->get("content","");
        $pageLimit=Yii::$app->request->get("limit","");
        $model=Banner::find();
        if($startTime){
            $model->andWhere([">=","banner_add_time",strtotime($startTime)]);
        }
        if($endTime){
            $model->andWhere(["<=","banner_add_time",strtotime($endTime)]);
        }
        if($content){
            if($key=="banner_id"){
                $model->where(["banner_id"=>$content]);
            }
            else{
                $model->where(["like","banner_name",$content]);
            }
        }
        $count=$model->count();
        $pageSize = Yii::$app->params['pageSize']['banner'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $memberList = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("index", ['pager' => $pager, 'memberList' => $memberList]);

    }

    public function actionAdd(){

        $this->layout = 'mainNotNavAndFooter';
        $bannerForm=new BannerForm();
        if(Yii::$app->request->isPost){
            $bannerData=Yii::$app->request->post();
            $banner=new Banner();
            if($banner->bannerAdd($bannerData)){
                Yii::$app->session->setFlash('info', '添加成功');
            }
            else{
                Yii::$app->session->setFlash('info', '添加失败');
            }
        }
        $categoryList = ArrayHelper::map(
            Category::find()->all(),
            'category_id',
            'category_name'
        );
        return $this->render("add",["bannerForm"=>$bannerForm,"categoryList"=>$categoryList]);
    }


    public function  actionEdit($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Banner();
        $post=Yii::$app->request->post();
        $post["member_id"]=$member_id;
        $result=$model->banner_edit($post);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"修改成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"修改失败!");
        }
        return $returnData;
    }

    public  function  actionView($member_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Banner();
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
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Banner();
        $result=$model->banner_delete($member_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }

    protected  function  getFirstError($model){

      return  array_values($model->getFirstErrors())[0];
    }


}
