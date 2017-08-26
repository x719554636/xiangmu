<?php

namespace frontend\controllers;

use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use frontend\models\Member;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    //验证码
    public function actions()
    {
        return  [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'minLength' => 3,
                'maxLength' => 3
            ]
        ]  ;
    }

//  注册
    public function actionRegist(){
        $model=new Member();
        if($model->load(\Yii::$app->request->post(),'')&& $model->validate()){
//         echo  $model->username;exit;
            if($model->password===$model->repassword){
                $model->created_at=time();
                $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password);
                $model->save(false);
                echo '保存成功';exit;
            }else{
                echo '保存失败';
                return $this->render('regist');
            }
//            echo $model->code;
//            exit;
        }
//            var_dump($model->getErrors());exit;
        return $this->render('regist');
    }
    //登录
    public function actionLogin(){

        $model=new Member();
        $model->scenario=Member::SCENARIO_ADD;
        if($model->load(\Yii::$app->request->post(),'')&& $model->validate()){
           if($model->login()){
//               echo "登陸成功"
               return $this->redirect(['header/index']);
           }else{
               return $this->redirect(['user/login']);
           }
        }
//        else{
//            var_dump($model->getErrors());exit;
//        }
        return $this->render('login');
    }
    //发送短信
    public function actionSms(){
        $rand=rand(10000,99999);
        $result=\Yii::$app->sms->setParams(['smscode'=>$rand])->setNumber(15123398929)->send();
        var_dump($result);
    }
    //退出登陸
    public function actionLogout(){
        \Yii::$app->user->logout();
        //跳转到首页
        return $this->redirect(['user/login']);
    }


}
