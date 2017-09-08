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

$form=ActiveForm::begin([
    "fieldConfig"=>[
        "template"=> '
                <label class="col-sm-2 control-label">{label}</label>
                <div class="col-sm-8">
                {input}{error}
                </div>
                '
    ],
    "options"=>[
        "class"=>"form-horizontal inline-input",
        "enctype"=>"multipart/form-data",
        "method "=>"post",
        "action"=>Url::toRoute(['area/add'])
    ]
]);
?>

<?=$form->field($banner,'banner_name')->textInput(["class"=>"form-control"]);?>
<?=$form->field($banner,"banner_image")->fileInput(["class"=>"form-control","name"=>"banner_image"]);?>
<div class="form-group">
    <div class=" col-sm-2 control-label">
        <label class="control-label" for="banner-banner_image">轮播原图片</label>
    </div>
    <div class=" col-sm-8">
        <?php
            echo '<img src="/uploads/images/'.$banner->banner_image.'" alt="轮播图图片" class="img-thumbnail" width="100" >';
        ?>
    </div>
</div>
<?=$form->field($banner,"banner_status")->radioList([1 => '启用', 2 => '禁用'], ["class"=>"form-control"]);?>
<?=$form->field($banner,"banner_category")->dropDownList($categoryList, ['prompt' => '请选择分类']);?>
<?=$form->field($banner,"banner_sort")->textInput(["class"=>"form-control","value"=>100]); ?>
<?=$form->field($banner,"banner_start_time")->textInput(["class"=>"Wdate form-control","onclick"=>"WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})"]); ?>
<?=$form->field($banner,"banner_end_time")->textInput(["class"=>"Wdate form-control","onclick"=>"WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})"]); ?>

    <div class="form-group">
        <div class=" col-sm-8">
        </div>
        <div class=" col-sm-4">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']); ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default']); ?>

        </div>
    </div>
<?php ActiveForm::end(); ?>