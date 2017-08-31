<?php

namespace app\modules\admin\controllers;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\Admin;
use app\modules\admin\models\Member;
use app\modules\admin\models\Banner;
use app\modules\admin\models\Category;
use app\modules\admin\models\Goods;
use app\modules\admin\models\Order;
use app\modules\admin\models\OrderGoods;

class IndexController extends Controller
{
    public  $layout = 'main';

    public function init(){
        $this->enableCsrfValidation = false;
    }
    public function actionIndex()
    {

        $adminCount=Admin::find()->count();
        $memberCount=Member::find()->count();
        $bannerCount=Banner::find()->count();
        $categoryCount=Category::find()->count();
        $goodsCount=Goods::find()->count();
        $orderCount=Order::find()->count();
        $orderGoodsCount=OrderGoods::find()->count();
        return $this->render("index",[
            "adminCount"=>$adminCount,
            "memberCount"=>$memberCount,
            "bannerCount"=>$bannerCount,
            "categoryCount"=>$categoryCount,
            "goodsCount"=>$goodsCount,
            "orderCount"=>$orderCount,
            "orderGoodsCount"=>$orderGoodsCount
        ]);
    }
}
