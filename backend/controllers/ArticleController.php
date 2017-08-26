<?php

namespace backend\controllers;

use backend\models\ArticleCategory;
use Yii;
use yii\web\UploadedFile;
use yii\data\Pagination;
class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //接收数据

        $model=ArticleCategory::find();
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
    //文章添加
    public function actionAdd(){
        //实例化模型
        $model=new ArticleCategory();
        //判定模型
        //实例化request
        $request=Yii::$app->request;
        if($request->isPost){
            //接收数据
            $model->load($request->post());
            //保存
            $model->save();
            //跳转
            return $this->redirect(['article/index']);
        }
        //调用视图
        return $this->render('add',['model'=>$model]);
    }
    //文章修改
    public function actionExid($id){
        //根据ID查询
        $model=ArticleCategory::findOne(['id'=>$id]);
        //判定模型
        //实例化request
        $request=Yii::$app->request;
        if($request->isPost){
            //接收数据
            $model->load($request->post());
            //保存
            $model->save();
            //跳转
            return $this->redirect(['article/index']);
        }
        //调用视图
        return $this->render('add',['model'=>$model]);
    }
//    文章删除
    public function actionDel($id){
        //接收数据
        $model=ArticleCategory::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        //跳转
        return $this->redirect(['article/index']);
    }

}
