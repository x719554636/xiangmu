<table class="table ">
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    <?php foreach ($permissions as $permissionss): ?>
    <tr>

        <td><?= $permissionss->name ?></td>
        <td><?= $permissionss->description ?></td>
        <td>
            <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['rbac/permission-edit','name'=>$permissionss->name])?>">编辑</a>
            <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['rbac/permission-del','name'=>$permissionss->name])?>">删除</a>
        </td>

    </tr>
    <?php endforeach; ?>
    <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['rbac/permission'])?>">添加</a>
</table>




