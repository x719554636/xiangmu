<?php

namespace backend\controllers;

use backend\models\Brand;
use Yii;
use yii\web\UploadedFile;
use yii\data\Pagination;
use flyok666\uploadifive\UploadAction;
use flyok666\qiniu\Qiniu;
class BrandController extends \yii\web\Controller
{
    //显示列表
    public function actionIndex()
    {
        //接收数据

        $model=Brand::find();
        $page = new Pagination([
            'totalCount'=>$model->count(),
            'defaultPageSize' => 2,
            'pageSizeLimit' => [1,2]
        ]);
        $rows=$model->where(['status'=>[0,1]])
            ->offset($page->offset)
            ->limit($page->pageSize)
            ->all();

        return $this->render('index',['model'=>$rows, 'pager' => $page]);
    }



    //用戶添加
    public function actionAdd(){
        //实例化模型
        $model=new Brand();
        //判定请求方式
        //实例化request组件
        $request=Yii::$app->request;
        if($request->isPost){
            //接收表单数据
            $model->load($request->post());
            //实例化上传文件
//            $model->imgFlie=UploadedFile::getInstance($model,'imgFlie');
            //验证数据

            if($model->validate()){
                //验证成功保存到数据库
                //保存上传文件
//                $flieName="/upload/".uniqid().".".$model->imgFlie->extension;
//                if($model->imgFlie->saveAs(\Yii::getAlias('@webroot').$flieName,false)){
//                    $model->logo = $flieName;
//                }
                $model->save();
                //设置提示信息
                Yii::$app->session->setFlash('success','添加成功');
                //跳转到首页
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }

        }
        //调用视图
        return $this->render('add',['model'=>$model]);
    }



    //用戶修改
    public function actionExid($id){
        //实例化模型
        $model=Brand::findOne($id);
        //判定请求方式
        //实例化request组件
        $request=Yii::$app->request;
        if($request->isPost){
            //接收表单数据
            $model->load($request->post());
            //实例化上传文件
//            $model->imgFlie=UploadedFile::getInstance($model,'imgFlie');
            //验证数据

            if($model->validate()){
                //验证成功保存到数据库
                //保存上传文件
//                $flieName="/upload/".uniqid().".".$model->imgFlie->extension;
//                if($model->imgFlie->saveAs(\Yii::getAlias('@webroot').$flieName,false)){
//                    $model->logo = $flieName;
//                }
                $model->save();
                //设置提示信息
                Yii::$app->session->setFlash('success','添加成功');
                //跳转到首页
                return $this->redirect(['brand/index']);
            }else{
                var_dump($model->getErrors());exit;
            }

        }
        //调用视图
        return $this->render('add',['model'=>$model]);
    }


    //用户删除
    public function actionDel($id){
        //获取数据
        $model=Brand::findOne(['id'=>$id]);
        //改变数据
        $model->status=-1;
        //保存
        $model->save();
        //跳转到首页
        return $this->redirect(['brand/index']);

    }

    public function actions(){
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,
                /*'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filename = sha1_file($action->uploadfile->tempName);
                    return "{$filename}.{$fileext}";
                },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                //格式化文件名
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = sha1(uniqid() . time());
                    $p1 = substr($filehash, 0, 2);
                    $p2 = substr($filehash, 2, 2);
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();//输出图片地址
                    //$action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    //$action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    //$action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                },
            ],
        ];
    }

    public function actionQiniu()
    {

        $config = [
            'accessKey'=>'hqNnJqiC0r7xoCcroZKMbqgbmELaZPyYmrbnNIDg',//AK
            'secretKey'=>'KwzsOiQ7UbAesjwXKh5fMblJCbbrOHuN6grCQxzq',//SK
            'domain'=>'http://otais5on2.bkt.clouddn.com/',//测试域名
            'bucket'=>'yii2shop',//存储空间名称
            'area'=>Qiniu::AREA_HUADONG//区域
        ];

        $qiniu = new Qiniu($config);
        $key = 'demo';//文件名
        $file = \Yii::getAlias('@webroot').'/upload/598c00c6d1f66.png';
        $qiniu->uploadFile($file,$key);//上传文件到七牛云存储
        $url = $qiniu->getLink($key);//根据文件名获取七牛云的文件路径
        var_dump($url);
    }


}
