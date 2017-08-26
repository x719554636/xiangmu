<?php

$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'password')->passwordInput();
echo $from->field($model,'password_x')->passwordInput();
echo $from->field($model,'password_s')->passwordInput();
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn-btn-info']);
\yii\bootstrap\ActiveForm::end();