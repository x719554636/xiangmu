<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsDayCount;
use backend\models\GoodsIntro;
use flyok666\uploadifive\UploadAction;
use yii\data\Pagination;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {

        //读取数据
        $model=Goods::find();
        //接收搜索数据

        if($modelGet=\Yii::$app->request->get('name')){
            $modelGet= \Yii::$app->request->get('name');
//            var_dump( $modelGet);exit;
            $page = new Pagination([
                'totalCount'=>$model->count(),
                'defaultPageSize' => 5,
            ]);
            $rows=$model->offset($page->offset)
                ->limit($page->pageSize)
                ->where(['status'=>[0,1]])->andWhere(['like','name',$modelGet])
                ->all();
            return $this->render('index',['model'=>$rows, 'pager' => $page]);
        }

        $page = new Pagination([
            'totalCount'=>$model->count(),
            'defaultPageSize' => 5,
        ]);
        $rows=$model->offset($page->offset)
            ->limit($page->pageSize)
            ->where(['status'=>[0,1]])
            ->all();
        return $this->render('index',['model'=>$rows, 'pager' => $page]);





    }


    //商品添加
    public function actionAdd(){
        //实例化模型
        $model=new Goods();
        $modelIntro=new GoodsIntro();
        $modelDay=new GoodsDayCount();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //接收数据
            $model->load(\Yii::$app->request->post());
            $modelIntro->load(\Yii::$app->request->post());
            //获取事件
            $time=date('Ymd',time());
            //获取条数
            $day=GoodsDayCount::find()->where(['day'=>$time])->count();
            $modelDay->count=$day+1;
            $modelDay->day=$time;
            //补0
            $dayTime=$time.str_pad($day+1,4,'0',STR_PAD_LEFT);
            $model->sn=$dayTime;
            $model->create_time=time();
            $model->save();
            $modelIntro->goods_id=$model->id;
            //保存
            $modelIntro->save();
            $modelDay->save();
            \Yii::$app->session->setFlash('success','商品添加成功');
            //跳转到本页
            return $this->refresh();
        }
        return $this->render('add',['model'=>$model,'modelIntro'=>$modelIntro]);
    }
    //商品添加
    public function actionExid($id){
        //实例化模型
        $model=Goods::findOne($id);
        $modelIntro=GoodsIntro::findOne(['goods_id'=>$id]);
        $modelDay=new GoodsDayCount();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //接收数据
            $model->load(\Yii::$app->request->post());
            $modelIntro->load(\Yii::$app->request->post());
            //获取事件
            $time=date('Ymd',time());
            //获取条数
            $day=GoodsDayCount::find()->where(['day'=>$time])->count();
            $modelDay->count=$day+1;
            $modelDay->day=$time;
            //补0
            $dayTime=$time.str_pad($day+1,4,'0',STR_PAD_LEFT);
            $model->sn=$dayTime;
            $model->create_time=time();
            $model->save();
            $modelIntro->goods_id=$model->id;
            //保存
            $modelIntro->save();

//            $modelDay->save();
            \Yii::$app->session->setFlash('success','商品修改成功');
            //跳转到本页
            return $this->redirect(['goods/index']);
        }
        return $this->render('exid',['model'=>$model,'modelIntro'=>$modelIntro,'modelDay'=>$modelDay]);
    }
    //商品刪除
    public function actionDel($id){
        //获取数据
        $model=Goods::findOne(['id'=>$id]);
        //改变数据
        $model->status=-1;
        //保存
        $model->save();
        \Yii::$app->session->setFlash('success','商品刪除成功');
        //跳转到首页
        return $this->redirect(['goods/index']);
    }


















//加载图片
    public function actions(){
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],
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







}
