<table class="table ">
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    <?php foreach ($roles as $role): ?>
    <tr>

        <td><?= $role->name ?></td>
        <td><?= $role->description ?></td>
        <td>
            <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['rbac/role-edit','name'=>$role->name])?>">编辑</a>
            <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['rbac/role-del','name'=>$role->name])?>">删除</a>
        </td>

    </tr>
    <?php endforeach; ?>
    <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['rbac/role'])?>">添加</a>
</table>




