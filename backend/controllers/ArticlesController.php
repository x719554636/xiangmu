<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii;

class ArticlesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //读取数据
        $model=Article::find();
        $page = new Pagination([
            'totalCount'=>$model->count(),
            'defaultPageSize' => 2,
            'pageSizeLimit' => [1,2]
        ]);
        $rows=$model->where(['status'=>[0,1]])
            ->offset($page->offset)
            ->limit($page->pageSize)
            ->all();
        
        return $this->render('index',['rows'=>$rows,'pager'=>$page]);
    }
    //文章的添加
    public function actionAdd(){
        //实例化模型
        $model=new Article();
        $row=ArticleCategory::find()->all();
        $model_article=new ArticleDetail();
        //判定模型
        //实例化request
        $request=Yii::$app->request;
        if($request->isPost){
            //接收数据
            $model->load($request->post());
//            var_dump($e);exit;
            $model_article->load($request->post());
            $model->create_time=time();
            //保存
            $model->save();
            $model_article->save();
//            var_dump($model->getErrors());exit;
            //跳转
            return $this->redirect(['articles/index']);
        }
        //调用视图
        return $this->render('add',['model'=>$model,'row'=>$row,'model_article'=>$model_article]);
    }
    //文章的添加
    public function actionExid($id){
        //实例化模型

        $model=Article::findOne($id);
        $row=ArticleCategory::find()->all();
        $model_article=ArticleDetail::findOne($id);
        //判定模型
        //实例化request
        $request=Yii::$app->request;
        if($request->isPost){
            //接收数据
            $model->load($request->post());
//            var_dump($e);exit;
            $model_article->load($request->post());
            //保存
            $model->save();
            $model_article->save();
            //跳转
            return $this->redirect(['articles/index']);
        }
        //调用视图
        return $this->render('add',['model'=>$model,'row'=>$row,'model_article'=>$model_article]);
    }
    public function actionDel($id){
        //接收数据
        $model=Article::findOne(['id'=>$id]);
        $model->status=-1;
        $model->save();
        //跳转
        return $this->redirect(['articles/index']);
    }

}
