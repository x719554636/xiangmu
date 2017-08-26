<?php
/* @var $this yii\web\View */
?>
<table class="table">
    <tr>
    <th>编号</th>
    <th>商品名称</th>
    <th>简介</th>
    <th>图片</th>
    <th>排序</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $v): ?>
    <tr>
        <td><?=$v->id; ?></td>
        <td><?=$v->name; ?></td>
        <td><?=$v->intro; ?></td>
        <td><img src="<?=$v->logo; ?>"></td>
        <td><?=$v->sort; ?></td>
        <td>
            <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['brand/exid','id'=>$v->id])?>">编辑</a>
            <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['brand/del','id'=>$v->id])?>">删除</a>
        </td>

    </tr>
    <?php endforeach;?>
    <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['brand/add'])?>">添加用户</a>

</table>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pager,
    'maxButtonCount' => 5,
    'hideOnSinglePage' => false
])?>
