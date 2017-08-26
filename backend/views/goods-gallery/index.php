<?php
$id=$_GET['id'];
use yii\web\JsExpression;
use yii\bootstrap\Html;


$this->registerJs(new JsExpression(<<<EOF
    $("#gallery").append('<tr data-id="'+data.id+'"><td><img src="'+data.fileUrl+'" /></td><td><button type="button" class="btn btn-danger del_btn">删除</button></td></tr>');
    }
    }
EOF
)
)
?>



<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['goods-gallery/add','id'=>$id])?>">添加用户</a>
<a class="btn btn-success" href="<?=\yii\helpers\Url::to(['goods/index'])?>">返回</a>
<table class="table">
    <tr>
        <th>编号</th>
        <th>LOGO</th>
        <th>操作</th>
    </tr>
    <?php foreach($model as $v): ?>
        <tr data-id="<?=$v->id;?>">
            <td><?=$v->id; ?></td>
            <td><img src="<?=$v->path; ?>"></td>
            <td>
            <td><?=Html::button('删除',['class'=>'btn btn-danger del_btn'])?></td>


        </tr>
    <?php endforeach;?>
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
$url = \yii\helpers\Url::to(['ajax-del']);
//删除图片
$this->registerJs(new JsExpression(
    <<<JS
    $("#gallery").on('click','.del_btn',function(){
    //$(".del_btn").click(function(){
        if(confirm('是否确认删除该图片？！')){
            var tr = $(this).closest('tr');
            //发起ajax请求，删除数据表记录
            var id = tr.attr('data-id');
            $.post("{$url}",{id:id},function(data){
                if(data=='success'){
                    tr.remove();//移除图片所在tr
                }else{
                    console.log(data);
                }
            });
        }
        
    });
JS
));
