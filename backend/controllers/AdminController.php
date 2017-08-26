<?php

namespace backend\controllers;

use backend\filters\RbacFilters;
use backend\models\Adimin;
use yii\data\Pagination;
use yii\captcha\CaptchaAction;
use backend\models\Edit;
use yii\helpers\ArrayHelper;


class AdminController extends \yii\web\Controller

{
    //配置行为（过滤器）
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilters::className(),
                'except'=>['login','logout','captcha','upload','s-upload'],//排除不需要权限验证的操作
            ]
        ];
    }



    //验证码
    public function actions()
    {
        return  [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'minLength' => 4,
                'maxLength' => 4
            ]
        ]  ;
    }



    public function actionIndex()
    {

        if(\Yii::$app->user->isGuest){
            \Yii::$app->session->setFlash('success','你还没有登录');
            //跳转到首页
            return $this->redirect(['admin/login']);
        }else{
            //查询数据
            $model=Adimin::find();
            $page = new Pagination([
                'totalCount'=>$model->count(),
                'defaultPageSize' => 5,
            ]);
            $rows=$model->where(['status'=>[1]])
                ->offset($page->offset)
                ->limit($page->pageSize)
                ->all();

            return $this->render('index',['model'=>$rows, 'pager' => $page]);
        }

    }


    //管理员添加
    public function actionAdd(){
        $model=new Adimin();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //保存
            $model->save();
            if(is_array($model->role)){
                $model->saves();
            }


            \Yii::$app->session->setFlash('success','管理员添加成功');
            //跳转到首页
            return $this->redirect(['admin/index']);
        }
        return $this->render('add',['model' => $model]);
    }

    //管理员修改

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionExid($id){
        $model=Adimin::findOne($id);
        $model->role = ArrayHelper::getColumn(\Yii::$app->authManager->getRolesByUser($id),'name');
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $model->password_hash=\Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->updated_at=time();
            $model->updates();
            $model->save();
            \Yii::$app->session->setFlash('success','管理员修改成功');
            //跳转到首页
            return $this->redirect(['admin/index']);
        }
        $model->password_hash="";
        return $this->render('add',['model' => $model]);
    }
    //管理员删除
    public function actionDel($id){

        $model=Adimin::findOne($id);
        $model->deletes();
        $model->delete();

        \Yii::$app->session->setFlash('success','管理员删除成功');
        //跳转到首页
        return $this->redirect(['admin/index']);
    }




    //管理员登录
    public function actionLogin(){
        $userObj=\Yii::$app->user;
        ;
//        接收数据
        $model=new Adimin();
        if($model->load(\Yii::$app->request->post())) {

            //接收用户名
            $usename = $model->username;
            $password=$model->password_hash;
            $auth_key=$model->auth_key;
//            var_dump($auth_ke);exit;
            if($auth_key){
                $auth_key=7*24*3600;
            }
//            $status=$model->status;
            $loginInfo=Adimin::findOne(['username'=>$usename]);
            //判断是否有用户
            if(empty($loginInfo)){
                \Yii::$app->session->setFlash('success','没有该用户');
                //跳转到首页
                return $this->redirect(['admin/login']);
            }
            //密码加密
            if(!\Yii::$app->security->validatePassword($password,$loginInfo->password_hash)){
                \Yii::$app->session->setFlash('success','用户名密码错误');
                //跳转到首页
                return $this->redirect(['admin/login']);
            }
            if($userObj->login($loginInfo,$auth_key)){
                $loginInfo->last_login_time=time();
                $loginInfo->last_login_ip=ip2long(\Yii::$app->request->userIP);
                $loginInfo->save();
                \Yii::$app->session->setFlash('success','登录成功');
                //跳转到首页
                return $this->redirect(['admin/index']);
            }
            \Yii::$app->session->setFlash('success','登录失败');

            //跳转到首页
            return $this->redirect(['admin/login']);

        }

        return $this->render('login',['model'=>$model]);
    }

    //用户退出
    public function actionLogout(){
        \Yii::$app->user->logout();
        \Yii::$app->session->setFlash('success','退出成功');
        //跳转到首页
        return $this->redirect(['admin/login']);
    }

    //修改密码
    public function actionEdit(){
        $model=new Edit();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->changePw()){
                \Yii::$app->session->setFlash('success','修改成功');
                //跳转到首页
                return $this->redirect(['admin/index']);
            }
        }
        return $this->render('edit',['model' => $model]);
    }

}
