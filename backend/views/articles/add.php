<?php
$arr=[];
foreach ($row as $v){
    $arr[$v['id']]=$v['name'];
}

$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'name');
echo $from->field($model,'intro')->textarea();
echo $from->field($model,'article_category_id')->dropDownList($arr,['prompt'=>"请选择"]);
echo $from->field($model,'sort')->textInput();
//echo $from->field($model,'create_time',);
echo $from->field($model,'status')->radioList([0=>'隐藏',1=>'正常']);
echo $from->field($model_article,'content')->textarea();

echo \yii\helpers\Html::submitButton('提交',['class'=>'btn-btn-info']);
\yii\bootstrap\ActiveForm::end();