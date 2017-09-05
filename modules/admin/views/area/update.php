<?php
use yii\helpers\Url;
?>
<form class="form-horizontal " enctype="multipart/form-data" method="post" action="<?= Url::toRoute(['area/update'])?>?area_id=<?= $areaInfo->area_id ?>">
    <div class="form-group">
        <label for="admin_name" class="col-sm-2 control-label"><span aria-hidden="true">&times;</span>上级：</label>
        <div class="col-sm-8">
            <select name="area_parent_id" class="form-control">
                <?php foreach($areaList as $key=>$value) {?>
                    <option value="<?php echo $value['area_id']; ?>"><?php echo $value['area_name']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="admin_permission" class="col-sm-2 control-label ">地区名称：</label>
        <div class="col-sm-8">
            <input  class="form-control" id="area_name" name="area_name" placeholder="地区名称" value="<?= $areaInfo->area_name ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="admin_password" class="col-sm-2 control-label">排序：</label>
        <div class="col-sm-8">
            <input  class="form-control" id="area_sort" name="area_sort" placeholder="排序" value="<?= $areaInfo->area_sort ?>">
        </div>
    </div>
    <input type="hidden" name="area_id" value="<?= $areaInfo->area_id ?>">
    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class=" col-sm-8">
            <button type="submit" class="btn btn-primary">提交</button>
            <button type="reset" class="btn btn-default">重置</button>
        </div>
    </div>
</form>
