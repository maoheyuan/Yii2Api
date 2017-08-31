<?php
use yii\helpers\Html;

?>
<ol class="breadcrumb">
    <li ><a href="{:U('Index/index')}">主页</a></li>
    <li class="active">首页统计</li>
    <div class="quit">
        <span type="button" >管理员:毛何远</span>
        <a href="#">[退出]</a>
    </div>
</ol>
<div style="background-color: #f8f8f8;border:1px solid #e7e7e7; text-align: right;padding-right:10px; ">
    <a  href="" class="btn btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i></a>
</div>
<div id="container" style="height: 80%;width: 80%;margin: 10px auto;"></div>

<?=Html::jsFile('@web/plug/echarts/echarts.min.js')?>
<script type="text/javascript">

    var dom = document.getElementById("container");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    option = {
        title: {
            text: ''
        },
        tooltip: {},
        legend: {
            data:['常用功能统计']
        },
        xAxis: {
            data: ["会员","订单","分类","商品","管理员","订单商品"]
        },
        yAxis: {},
        series: [{
            name: '常用功能统计',
            type: 'bar',
            data: [<?= $memberCount ?>, <?= $orderCount ?>, <?= $orderCount ?>, <?= $goodsCount ?>, <?= $adminCount ?>,<?= $orderGoodsCount ?>]
        }]
    };;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }

</script>
