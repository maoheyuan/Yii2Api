<?php
use yii\helpers\Url;
?>

<?php  if(Yii::$app->session->getFlash("loginError")) {?>
    <div class="form-group">

        <p><?= Yii::$app->session->getFlash("loginError") ?></p>
    </div>
<?php };?>

<form class="form-horizontal " enctype="multipart/form-data" method="post" action="<?= Url::toRoute(['admin/add'])?>">
    <div class="form-group">
        <label for="admin_name" class="col-sm-2 control-label"><span aria-hidden="true">&times;</span>管理员名称：</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="管理员名称">
        </div>
    </div>


    <div class="form-group">
        <label for="admin_permission" class="col-sm-2 control-label ">管理员权限：</label>
        <div class="col-sm-8">
            <textarea  class="form-control" id="admin_permission"   name="admin_permission" placeholder="管理权限" rows="20"></textarea>

        </div>
    </div>


    <div class="form-group">
        <label for="admin_password" class="col-sm-2 control-label">管理员密码：</label>
        <div class="col-sm-8">
            <input  class="form-control" id="admin_password" name="admin_password" placeholder="管理员密码">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">超级管理员：</label>
        <div class="col-sm-8">
            <label class="radio-inline">
                <input type="radio" name="admin_is_super"  value="1" checked> 是
            </label>
            <label class="radio-inline">
                <input type="radio" name="admin_is_super"  value="0"> 否
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class=" col-sm-8">
            <button type="submit" class="btn btn-primary">提交</button>
            <button type="reset" class="btn btn-default">重置</button>
        </div>
    </div>
</form>

<script src="__PUBLIC__/admin/js/ajaxfileupload.js"></script>
<script type="text/javascript">
    $("#body").addClass("create-page");
</script>
