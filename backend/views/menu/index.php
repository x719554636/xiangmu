<?php
/* @var $this yii\web\View */


use yii\web\JsExpression;
?>
<table class="table" id="menu-table">
    <tr>
    <th>编号</th>
    <th>名称</th>
    <th>路由</th>
    <th>排序</th>
    <th>操作</th>
    </tr>
    <?php foreach($model as $v): ?>
    <tr data-id="<?=$v->id;?>">
        <td><?=$v->id; ?></td>
        <td><?=$v->label; ?></td>
        <td><?=$v->url; ?></td>
        <td><?=$v->sort; ?></td>
        <td>
            <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['menu/exid','id'=>$v->id])?>">编辑</a>
            <button class="btn btn-success del-btn" >删除</button>
        </td>

    </tr>
    <?php endforeach;?>
    <a class="btn btn-success" href="<?=\yii\helpers\Url::to(['menu/add'])?>">添加菜单</a>

</table>
<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pager,
    'maxButtonCount' => 5,
    'hideOnSinglePage' => false
])?>

<?php
/**
 * @var $this \yii\web\View
 */
$url = \yii\helpers\Url::to(['menu/del']);
//删除图片
$this->registerJs(new JsExpression(
    <<<JS
    $("#menu-table").on('click','.del-btn',function(){
    //$(".del_btn").click(function(){
        if(confirm('是否确认删除该菜單？！')){
            var tr = $(this).closest('tr');
            //发起ajax请求，删除数据表记录
            var id = tr.attr('data-id');
            $.post("{$url}",{id:id},function(data){
                if(data=='success'){
                    tr.remove();//移除所在tr
                }else{
                    console.log(data);
                }
            });
        }
        
    });
JS
));
