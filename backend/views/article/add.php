<?php
$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'name');
echo $from->field($model,'intro')->textarea();
echo $from->field($model,'sort')->textInput();
echo $from->field($model,'status')->radioList([0=>'隐藏',1=>'正常']);
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn-btn-info']);
\yii\bootstrap\ActiveForm::end();