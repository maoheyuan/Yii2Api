<?php

namespace app\modules\admin\controllers;
use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use app\helper\helper;
use app\helper\tree;
use yii\data\Pagination;
use app\modules\admin\models\MemberAddress;

class MemberAddressController extends BaseController
{
    public function actionIndex(){

        $this->layout="main";
        $getData=Yii::$app->request->get();
        $startTime=Yii::$app->request->get("startTime","");
        $endTime=Yii::$app->request->get("endTime");
        $key=Yii::$app->request->get("key","");
        $content=Yii::$app->request->get("content","");
        $pageLimit=Yii::$app->request->get("limit","");
        $model=MemberAddress::find();
        if($startTime){
            $model->andWhere([">=","maddress_add_time",strtotime($startTime)]);
        }
        if($endTime){
            $model->andWhere(["<=","maddress_add_time",strtotime($endTime)]);
        }
        if($content){
            if($key=="maddress_id"){
                $model->where(["maddress_id"=>$content]);
            }
            else{
                $model->where(["like","maddress_member_id",$content]);
            }
        }
        $count=$model->count();
        $pageSize = Yii::$app->params['pageSize']['banner'];
        $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $memberList = $model->offset($pager->offset)->limit($pager->limit)->all();
        return $this->render("index", ['pager' => $pager, 'memberList' => $memberList]);

    }

    protected function  categoryTree($banner_category=0)
    {
        try{
            $categoryList = Category::find()->asArray()->all();

            foreach($categoryList as $r) {
                $r["id"]=$r["category_id"];
                $r["parentId"]=$r["category_parent_id"];
                $r['selected'] = $r['id'] == $banner_category ? 'selected' : '';
                $array[] = $r;
            }
            $str  = "<option value='\$id' \$selected>\$spacer \$category_name</option>";
            $tree = new tree ($array);
            $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─','&nbsp;&nbsp;&nbsp;└─ ');
            $list = $tree->get_tree(0, $str,$banner_category);
            return $list;

        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
    }

    protected function  getCategoryTree()
    {
        try{
            $categoryList = Category::find()->asArray()->all();

            foreach($categoryList as $r) {
                $r["id"]=$r["category_id"];
                $r["parentid"]=$r["category_parent_id"];
                $r["title"]=$r["category_name"];
               $array[] = $r;
            }
            $tree = new tree (array());
            $categoryTree=$tree->getTree($array);
            $categoryTree = $tree->setPrefix($categoryTree);

            return $categoryTree;
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }
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
        $categoryTree=$this->getCategoryTree();
        $categoryList = ArrayHelper::map(
            $categoryTree,
            'category_id',
            'title'
        );

        //$categoryTree=$this->categoryTree($banner->banner_category);
        $banner->scenario="bannerAdd";
        return $this->render("add",[
                "banner"=>$banner,
                "categoryList"=>$categoryList,
                "categoryTree"=>$categoryTree
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
        $categoryTree=$this->getCategoryTree();
        $categoryList = ArrayHelper::map(
            $categoryTree,
            'category_id',
            'title'
        );
        $banner->scenario="bannerEdit";
        return $this->render("edit",[
            "banner"=>$banner,
            "categoryList"=>$categoryList
        ]);
    }



    public function actionDelete($banner_id){
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model=new Banner();
        $result=$model->bannerDelete($banner_id);
        if($result){
            $returnData=Helper::returnData(true,["id"=>$result],"删除成功!");
        }
        else{
            $returnData=Helper::returnData(false,[],"删除失败!");
        }
        return $returnData;
    }

}
