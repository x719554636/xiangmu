<?php

?>
<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['goods/add'])?>">添加用户</a>
<form class="form-inline" action="/goods/index" method="get" role="form">
    <div class="form-group field-articlesearchform-name">
        <input type="text" id="articlesearchform-name" class="form-control" name="name" placeholder="标题">
    </div>
    <button type="submit" class="btn btn-default glyphicon glyphicon-zoom-in">搜索</button>
    <button type="submit" class="btn btn-default glyphicon glyphicon-repeat" href="<?=\yii\helpers\Url::to(['goods/index'])?>">返回</button>
</form>


<table class="table">
    <tr>
        <th>编号</th>
        <th>货号</th>
        <th>名称</th>
        <th>价格</th>
        <th>库存</th>
        <th>LOGO</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $v): ?>
        <tr>
            <td><?=$v->id; ?></td>
            <td><?=$v->sn; ?></td>
            <td><?=$v->name; ?></td>
            <td><?=$v->shop_price; ?></td>
            <td><?=$v->stock; ?></td>
            <td><img src="<?=$v->logo; ?>"></td>
            <td>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['goods-gallery/index','id'=>$v->id])?>">相册</a>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['goods/exid','id'=>$v->id])?>">编辑</a>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['goods/del','id'=>$v->id])?>">删除</a>
            </td>

        </tr>
    <?php endforeach;?>


</table>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pager,
//    'maxButtonCount' => 5,
//    'hideOnSinglePage' => false
])?>
