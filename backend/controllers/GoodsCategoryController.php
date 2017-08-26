<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\data\Pagination;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //顯示页面
        $model= GoodsCategory::find();
        $page = new Pagination([
            'totalCount'=>$model->count(),
            'defaultPageSize' => 2,
            'pageSizeLimit' => [1,2]
        ]);
        $rows=$model->offset($page->offset)
            ->limit($page->pageSize)
            ->all();

        return $this->render('index',['model'=>$rows, 'pager' => $page]);
    }
    //商品分类添加
    public function actionAdd(){
        $model=new GoodsCategory();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //判断是添加顶级分类还是子分类
            if($model->parent_id){
                //添加子分类
                $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                //创建子分类
                $model->prependTo($parent);
            }else{
                //添加顶级分类
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','分类添加成功');
            //跳转到本页
            return $this->refresh();
        }
        return $this->render('add',['model'=>$model]);
    }


    //商品分类修改
    public function actionExid($id){
        $model=GoodsCategory::findOne($id);
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            //判断是添加顶级分类还是子分类
            if($model->parent_id){
                //添加子分类
                $parent = GoodsCategory::findOne(['id'=>$model->parent_id]);
                //创建子分类
                $model->prependTo($parent);
            }else{
                $oldmodel=GoodsCategory::findOne($id);
                $oldmodel->parent_id;
                //判断是否是根节点
                if($oldmodel->parent_id){
                    //添加顶级分类
                    $model->makeRoot();
                }else{
                    $model->save();
                }

            }
            \Yii::$app->session->setFlash('success','分类修改成功');
            //跳转到本页
            return $this->redirect(['goods-category/index']);
        }
        return $this->render('exid',['model'=>$model]);
    }


//    删除
    public function actionDel($id){
        $model=GoodsCategory::findOne($id);
        //判定父节点下是否有子节点
        //isLeaf()判断是否有叶子
        if(!GoodsCategory::find()->where(['parent_id'=>$id])->count()){
            $model->deleteWithChildren();
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect(['goods-category/index']);
        }
            \Yii::$app->session->setFlash('success','不能删除有子节点的');
            //跳转到本页
            return $this->redirect(['goods-category/index']);


    }

}
