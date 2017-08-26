<?php
use yii\web\JsExpression;

$form = \yii\bootstrap\ActiveForm::begin();
//name	varchar(50)	名称
echo $form->field($model,'name');
//保存上传文件的路径
echo $form->field($model,'description')->textInput();
echo $form->field($model,'permissions')->checkboxList(\backend\models\RoleForm::getPermissionItems());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();



