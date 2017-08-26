<?php

namespace backend\controllers;

use backend\models\GoodsGallery;
use flyok666\uploadifive\UploadAction;
use yii\data\Pagination;
class GoodsGalleryController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $model=GoodsGallery::find();
        $page = new Pagination([
            'totalCount'=>$model->count(),
            'defaultPageSize' => 8,
        ]);
        $models=$model->where(['goods_id'=>$id])
            ->offset($page->offset)
            ->limit($page->pageSize)
            ->all();


        return $this->render('index',['model'=>$models,'pager' => $page]);
    }
    //图片添加
    public function actionAdd($id){
        $model=new GoodsGallery();
//        echo $id;exit;

        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //接收数据
            $model->load(\Yii::$app->request->post());
            $model->goods_id=$id;
            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            //跳转到本页
            return $this->refresh();
        }

        return $this->render('add',['model'=>$model]);
    }



//    public function actionDel($id){
//        $ids=GoodsGallery::findOne($id);
//        GoodsGallery::findOne($id)->delete();
//        \Yii::$app->session->setFlash('success','删除成功');
//        return $this->redirect(['goods-gallery/index','id'=>$ids->goods_id]);
//    }
    //ajax删除图片
    public function actionAjaxDel()
    {
        $model = GoodsGallery::findOne(['id'=>\Yii::$app->request->post('id')]);
        if($model){
            $model->delete();
            return 'success';
        }
        return 'fail';
    }





    //加载图片
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




}
















