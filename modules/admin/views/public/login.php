<?php
use yii\helpers\Url;
?>
<div class="login">
    <form action="<?/*=  Url::toRoute(['public/login']); */?>" method="post">
        <div class="form-group">
            <h3 class="text-center">登&nbsp;&nbsp;录</h3>
        </div>
        <div class="form-group">
            <input type="input" class="form-control" name="adminName" placeholder="用户名" value="<?= $adminName ?>">
        </div>
        <div class="form-group">
            <input type="password" class="form-control"  name="password" placeholder="密码">
        </div>
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken?>">

        <?php  if(Yii::$app->session->getFlash("loginError")) {?>
        <div class="form-group">

            <p><?= Yii::$app->session->getFlash("loginError") ?></p>
        </div>
        <?php };?>

        <button type="submit" class="btn btn-success btn-block">登&nbsp;&nbsp;录</button>
    </form>
</div>

