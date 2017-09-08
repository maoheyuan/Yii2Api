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
use yii\web\UploadedFile;

class BannerController extends BaseController
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
        $banner=new Banner();
        if(Yii::$app->request->isPost){
            $bannerData=Yii::$app->request->post();
            $imageInfo = \Yii::$app->mhyUploadsFile->uploadsImage('banner_image');
            if ($imageInfo["status"]) {
                $bannerData["Banner"]["banner_image"]=$imageInfo["data"];
                if($bannerId=$banner->bannerAdd($bannerData)) {
                    return $this->success('添加成功',"banner/add");
                }
                else{
                    $error=Helper::getFirstError($banner);
                    return $this->error($error);
                }
            }
            else{
                return $this->error('图片保存失败');
            }
        }
        $categoryList = ArrayHelper::map(
            Category::find()->all(),
            'category_id',
            'category_name'
        );
        $banner->scenario="bannerAdd";
        return $this->render("add",[
                "banner"=>$banner,
                "categoryList"=>$categoryList
            ]);
    }

    public function  actionEdit($banner_id){
        $this->layout = 'mainNotNavAndFooter';
        $bannerModel=new Banner();
        $banner=$bannerModel->getInfoById($banner_id);
        if(Yii::$app->request->isPost){
            $bannerData=Yii::$app->request->post();
            $imageInfo= \Yii::$app->mhyUploadsFile->uploadsImage('banner_image');
            if($imageInfo["status"] ==0&&$imageInfo["data"]!=400){
                return $this->error('图片保存失败');
            }
            if($imageInfo["status"] ==1){
                $bannerData["Banner"]["banner_image"]=$imageInfo["data"];
            }
            $bannerData["Banner"]["banner_id"]=$banner_id;
            if($banner->bannerEdit($bannerData)) {
                return $this->success('修改成功',["banner/edit", 'banner_id' => $banner_id]);
            }
            else{
                $error=Helper::getFirstError($banner);
                return $this->error($error);
            }
        }
        $categoryList = ArrayHelper::map(
            Category::find()->all(),
            'category_id',
            'category_name'
        );
        $banner->scenario="bannerEdit";
        return $this->render("edit",[
            "banner"=>$banner,
            "categoryList"=>$categoryList
        ]);
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
