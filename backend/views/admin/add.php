<?php

$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password_hash')->passwordInput();
//echo $from->field($model,'password_reset_token')->textInput();
echo $form->field($model,'email')->textInput();
echo $form->field($model,'role')->checkboxList(\backend\models\Adimin::getRoleItems());
echo $form->field($model,'status')->radioList([0=>'隐藏',1=>'正常']);
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn-btn-info']);
\yii\bootstrap\ActiveForm::end();