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
                <label class="col-sm-1 control-label">{label}</label>
                <div class="col-sm-11">
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
<?=$form->field($model,'banner_name')->textInput(["class"=>"form-control","id"=>"banner_name","name"=>"banner_name"]);?>
<?=$form->field($model,"banner_image")->fileInput(["class"=>"form-control","id"=>"banner_image","name"=>"banner_image"]);?>
<?= $form->field($model,"banner_status")->radioList([1 => '启用', 2 => '禁用'], ["class"=>"form-control","id"=>"banner_name","name"=>"banner_name"]);?>
<?= $form->field($model,"banner_category")->dropDownList(array(), ['id' => 'banner_category']);?>
<?= $form->field($model,"banner_sort")->textInput(["class"=>"form-control","id"=>"banner_sort","name"=>"banner_sort"]); ?>
<div class="form-group">
    <div class="col-sm-10"></div>
    <div class=" col-sm-2">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']); ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']); ?>

    </div>
</div>
<?php ActiveForm::end(); ?>