<?php

use yii\helpers\Url;

?>
<ol class="breadcrumb">
    <li><a href="<?= Url::toRoute(['index/index'])?>">主页</a></li>
    <li>管理员管理</li>
    <li class="active">管理员列表</li>
    <div class="quit">
        <span type="button" >管理员:毛何远</span>
        <a href="#">[退出]</a>
    </div>
</ol>

<nav class="navbar navbar-default">
    <div class="container-fluid pdl0">
        <div class="collapse navbar-collapse pdl0" id="bs-example-navbar-collapse-1">
            <form class="navbar-form navbar-left pdl2">

                <div class="btn-group form-group" >

                    <button type="button" class="btn btn-primary create" title="轮播图新增" data-url="<?= Url::toRoute(['banner/add'])?>"><i class="fa fa-plus" aria-hidden="true"></i></button>

                </div>
                <div class="form-group">
                    <input type="text" class="Wdate form-control  laydate-icon " placeholder="开始时间"
                           onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="startTime" value="<?= isset($request['startTime'])&&$request['startTime'] ?>">
                </div>
                <div class="form-group">
                    <input type="text" class="Wdate form-control  laydate-icon " placeholder="结束时间"
                           onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="endTime" value="<?=isset($request['endTime'])&&$request['endTime']?>">
                </div>
                <div class="form-group">
                    <select name="limit" class="form-control">
                        <option value=""  >请选择</option>
                        <option value="20" <?= isset($request['limit'])&& $request['limit'] == 20 ? "selected":"" ?> >20条</option>
                        <option value="30" <?= isset($request['limit'])&&$request['limit'] == 30 ? "selected":"" ?> >30条</option>
                        <option value="50" <?= isset($request['limit'])&&$request['limit'] == 50 ? "selected":"" ?> >50条</option>
                    </select>

                </div>
                <div class="form-group">
                    <select name="key" class="form-control">
                        <option value="">请选择</option>
                        <option value="banner_id"     <?= isset($request['key'])&&$request['key'] == 'banner_id' ?"selected":"" ?> >轮播图编号</option>
                        <option value="banner_name"   <?=isset($request['key'])&&$request['key'] == 'banner_name' ?"selected":"" ?> >轮播图名称</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="content" placeholder="内容" value="<?=isset($request['content'])&&$request['content']?>">
                </div>
                <button type="submit" name="submit" value="submit" class="btn btn-primary">查找</button>
                <button id="reset" type="button" class="btn btn-default">重置</button>
                <button type="submit" name="submit" value="export" class="btn btn-default">导出</button>
                <a  href="" class="btn btn-primary"><i class="fa fa-refresh" aria-hidden="true"></i></a>
            </form>


        </div>
    </div>
</nav>

<div class="ml5">
    <table class="table table-bordered table-hover ">
        <thead>
        <tr class="info">
            <th><input id="select-all" type="checkbox"></th>
            <th >编号</th>
            <th >名称</th>
            <th >图片</th>
            <th >状态</th>
            <th >所属分类</th>
            <th>有效开始时间</th>
            <th>有效结束时间</th>
            <th>新增时间</th>
            <th>修改时间</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($memberList as $key=>$vo){ ?>
            <tr id="row<?=$vo['banner_id']?>">
                <td><input  type="checkbox"></td>
                <td><?=$vo["banner_id"]?></td>
                <td><?=$vo["banner_name"]?></td>
                <td><?=$vo["banner_image"]?></td>
                <td><?=$vo["banner_status"]?></td>
                <td><?=$vo["banner_category"]?></td>
                <td><?=$vo["banner_start_time"]?></td>
                <td><?=$vo["banner_end_time"]?></td>
                <td><?=$vo["banner_add_time"]?></td>
                <td><?=$vo["banner_edit_time"]?></td>
                <td><?=$vo["banner_sort"]?></td>
                <td>
                    <a  class="btn btn-warning  btn-sm update" title="管理员修改" data-url="<?= Url::toRoute(['banner/edit'])?>?banner_id=<?= $vo['banner_id']?>"><i class="fa fa-edit" aria-hidden="true"></i> </a>
                    <a  class="btn btn-danger   btn-sm delete"  title="管理员删除" data-id="<?= $vo['banner_id']?>" data-url="<?= Url::toRoute(['banner/delete'])?>?banner_id=<?= $vo['banner_id']?>"> <i class="fa fa-trash-o fa-lg"></i></a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="pagination pull-right">
        <?php echo yii\widgets\LinkPager::widget([
            'pagination' => $pager,
            'prevPageLabel' => '&#8249;',
            'nextPageLabel' => '&#8250;',
        ]); ?>
    </div>
</div>
