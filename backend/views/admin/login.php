<?php

$from=\yii\bootstrap\ActiveForm::begin();
echo $from->field($model,'username');
echo $from->field($model,'password_hash')->passwordInput();
echo $from->field($model, 'code')->widget('yii\captcha\Captcha', [
    'captchaAction'=>'admin/captcha',
    'template' => '<div class="row"><div class="col-lg-9 col-md-9">{input}</div><div class="col-lg-3 col-md-3">{image}</div></div>'
]);
echo $from->field($model,'auth_key')->checkbox();
echo \yii\helpers\Html::submitButton('提交',['class'=>'btn-btn-info']);
\yii\bootstrap\ActiveForm::end();