<?php

namespace backend\controllers;

use backend\models\Menu;
use yii\data\Pagination;


class MenuController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model=Menu::find();
        $page = new Pagination([
            'totalCount'=>$model->count(),
            'defaultPageSize' =>5,
        ]);
        $rows=$model->offset($page->offset)
            ->limit($page->pageSize)
            ->all();

        return $this->render('index',['model'=>$rows, 'pager' => $page]);
    }
    //菜單添加
    public function actionAdd(){
        $model=new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','添加成功');
            return $this->redirect(['index']);
        }
        return $this->render('add',['model'=>$model]);
    }
    //菜单修改
    public function actionExid($id){
        $model=Menu::findOne($id);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $model->save();
            \Yii::$app->session->setFlash('success','修改成功');
            return $this->redirect(['index']);
        }
        return $this->render('add',['model'=>$model]);
    }



    //菜单删除
    public function actionDel(){
        $model=Menu::findOne(\Yii::$app->request->post('id'));
        if($model->parent_id===0){
            if(Menu::find()->where(['id'=>$model->id])->count()){
                \Yii::$app->session->setFlash('success','不能删除有儿子的');
                return 'fail';
            }
        }
        Menu::findOne(\Yii::$app->request->post('id'))->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return 'success';
    }
}
