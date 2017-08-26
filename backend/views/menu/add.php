<?php
use yii\web\JsExpression;

$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'label');
echo $form->field($model,'parent_id')->dropDownList(\backend\models\Menu::getMenu());
echo $form->field($model,'url')->dropDownList(\backend\models\Menu::getPermission());
echo $form->field($model,'sort');
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();

