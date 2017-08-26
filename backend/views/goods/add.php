<?php
use yii\web\JsExpression;

$form = \yii\bootstrap\ActiveForm::begin();
//name	varchar(50)	名称
echo $form->field($model,'name');
//保存上传文件的路径
echo $form->field($model,'logo')->hiddenInput();
//外部TAG
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['someKey' => 'someValue'],//传递数据
        'width' => 80,
        'height' => 30,
        'onError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
        ),
        'onUploadComplete' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
        //图片回显
        $("#img").attr("src",data.fileUrl);
        //将图片地址写入到logo隐藏输入框
        $("#goods-logo").val(data.fileUrl);
    }
}
EOF
        ),
    ]
]);
echo \yii\bootstrap\Html::img($model->logo,['id'=>'img']);
//商品分类

echo $form->field($model,'goods_category_id')->hiddenInput();
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';



//品牌分类
echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getGoodsItems(),['prompt'=>"请选择"]);
//市场价格
echo $form->field($model,'market_price')->textInput();
//商品价格
echo $form->field($model,'shop_price')->textInput();
//sort	int(11)	排序
echo $form->field($model,'sort')->textInput();
//status	int(2)	状态(-1删除 0隐藏 1正常)
echo $form->field($model,'status')->radioList([0=>'隐藏',1=>'正常']);
//is_on_sale
echo $form->field($model,'is_on_sale')->radioList([0=>'下架',1=>'上架']);
//库存
echo $form->field($model,'stock')->textInput();
//商品详情
//content	text	商品描述
//echo $form->field($modelIntro,'content')->textarea();
echo $form->field($modelIntro,'content')->widget('kucha\ueditor\UEditor',[]);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();


$zNodes = \backend\models\GoodsCategory::getZNodes();
//加载ztree的静态资源
//加载css文件
//$this->registerCssFile('@web/zTree/css/demo.css');
$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
//加载js文件   //depends 依赖关系
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);
//加载js代码
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
 var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            },
            callback:{
                onClick:function(event, treeId, treeNode){
                    console.log(treeNode.id);
                    //赋值给parent_id
                    $("#goods-goods_category_id").val(treeNode.id);
                }
            }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
       var zNodes = {$zNodes};


       zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
       //展开所有节点
       zTreeObj.expandAll(true);
            //修改功能   根据当前分类的parent_id选中节点
       var node = zTreeObj.getNodeByParam("id", "{$model->goods_category_id}", null);
       // 根据id获取节点
       zTreeObj.selectNode(node);
JS
));
