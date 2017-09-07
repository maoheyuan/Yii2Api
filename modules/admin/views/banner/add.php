<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<style>
    .form-control{
        height: auto !important;
    }
</style>
<?php
    if (Yii::$app->session->hasFlash('info')) {
        echo '<div class="alert alert-danger well-sm" role="alert">'.Yii::$app->session->getFlash('info').'</div>';
    }
    $form=ActiveForm::begin([
         "fieldConfig"=>[
             "template"=> '
                <label class="col-sm-2 control-label">{label}</label>
                <div class="col-sm-10">
                {input}{error}
                </div>'
         ],
         "options"=>[
             "class"=>"form-horizontal inline-input",
             "enctype"=>"multipart/form-data",
             "method "=>"post",
             "action"=>Url::toRoute(['area/add'])
         ]
    ]);
?>
<?=$form->field($bannerForm,'banner_name')->textInput(["class"=>"form-control","id"=>"banner_name","name"=>"banner_name"]);?>
<?=$form->field($bannerForm,"banner_image")->fileInput(["class"=>"form-control","id"=>"banner_image","name"=>"banner_image"]);?>
<?= $form->field($bannerForm,"banner_status")->radioList([1 => '启用', 2 => '禁用'], ["class"=>"form-control","id"=>"banner_name","name"=>"banner_name"]);?>
<?= $form->field($bannerForm,"banner_category")->dropDownList($categoryList, ['prompt' => '请选择分类','id' => 'banner_category']);?>
<?= $form->field($bannerForm,"banner_sort")->textInput(["class"=>"form-control","id"=>"banner_sort","name"=>"banner_sort"]); ?>
<?= $form->field($bannerForm,"banner_start_time")->textInput(["class"=>"Wdate form-control","onclick"=>"WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})","id"=>"banner_start_time","name"=>"banner_start_time"]); ?>
<?= $form->field($bannerForm,"banner_end_time")->textInput(["class"=>"Wdate form-control","onclick"=>"WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})","id"=>"banner_end_time","name"=>"banner_end_time"]); ?>

<div class="form-group">
    <div class="col-sm-9"></div>
    <div class=" col-sm-3">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']); ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']); ?>

    </div>
</div>
<?php ActiveForm::end(); ?>