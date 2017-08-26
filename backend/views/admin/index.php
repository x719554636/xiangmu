<?php

?>

<table class="table">
    <tr>
        <th>编号</th>
        <th>用戶名</th>
        <th>邮箱</th>
        <th>状态</th>
        <th>操作</th>


    </tr>
    <?php foreach($model as $v): ?>
        <tr>
            <td><?= $v->id  ?></td>
            <td><?= $v->username  ?></td>
            <td><?= $v->email  ?></td>
            <td><?= $v->status=1?'正常':'停用'  ?></td>
            <td>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['admin/exid','id'=>$v->id])?>">编辑</a>
                <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['admin/del','id'=>$v->id])?>">删除</a>
            </td>

        </tr>
    <?php endforeach;?>
    <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['admin/add'])?>">添加用户</a>
    <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['admin/edit'])?>">修改密码</a>
    <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['admin/logout'])?>">退出</a>
</table>

<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pager,
//    'maxButtonCount' => 5,
//    'hideOnSinglePage' => false
])?>