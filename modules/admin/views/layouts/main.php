<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <style type="text/css">
        .laydate_box, .laydate_box * {
            box-sizing:content-box;
        }
        .laydate-icon{
            height: 34px !important;
            line-height: 34px !important;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div  class="navLeftBar">
    <div  class="list-group ">
        <a class="list-group-item  web_log"><img src="<?= Yii::$app->request->hostInfo ?>/image/web_login.png" width="400%"></a>
    </div>
    <div  class="list-group">
        <a class="list-group-item part-line" href="<?= Url::toRoute("index/index")?>">
            <i class="fa fa-user pd5" aria-hidden="true"></i>我的首页
        </a>

        <a class="list-group-item " href="<?= Url::toRoute("admin/index")?>">
            <i class="fa fa-user pd5" aria-hidden="true"></i>管理员管理
        </a>
        <a class="list-group-item " href="<?= Url::toRoute("member/index")?>">
            <i class="fa fa-user pd5" aria-hidden="true"></i>会员管理
        </a>

        <a class="list-group-item " href="<?= Url::toRoute("order/index")?>">
            <i class="fa fa-reorder pd5" aria-hidden="true"></i>订单管理
        </a>
        <a class="list-group-item" href="<?= Url::toRoute("category/index")?>">
            <i class="fa fa-database pd5" aria-hidden="true"></i>商品分类
        </a>
        <a class="list-group-item" href="<?= Url::toRoute("goods/index")?>">
            <i class="fa fa-recycle pd5" aria-hidden="true"></i>商品管理
        </a>
        <a class="list-group-item" href="<?= Url::toRoute("area/index")?>">
            <i class="fa fa-area-chart pd5" aria-hidden="true"></i>地区管理
        </a>
        <a class="list-group-item" href="<?= Url::toRoute("memberAddress/index")?>">
            <i class="fa fa-university pd5" aria-hidden="true"></i>地址管理
        </a>
        <a class="list-group-item" href="<?= Url::toRoute("banner/index")?>">
            <i class="fa fa-history pd5" aria-hidden="true"></i>轮播管理
        </a>

        <a class="list-group-item" href="<?= Url::toRoute("config/index")?>">
            <i class="fa fa-cog fa-fw pd5" aria-hidden="true"></i>常用设置
        </a>
        <a class="list-group-item" href="<?= Url::toRoute("chart/index")?>">
            <i class="fa fa-calendar pd5" aria-hidden="true"></i>统计管理
        </a>
        <a class="list-group-item " href="{:U('admin/self')}">
            <i class="fa fa-user pd5" aria-hidden="true"></i> 我的中心
        </a>

    </div >

</div>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
