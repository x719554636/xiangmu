<?php

namespace frontend\controllers;

use frontend\models\Address;

class AddressController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;

    //添加收货地址
    public function actionAddress()
    {
        $model=new Address();
        $models=Address::find()->all();
        if($model->load(\Yii::$app->request->post(),'')&& $model->validate()){
            $model->member_id=\Yii::$app->user->id;
            $model->save();
            echo '添加成功';exit;
        }
//        else{
//            var_dump($model->getErrors());exit;
//        }

        return $this->render('address',['model_one'=>$model,'models'=>$models]);
    }

    //显示收货地址
    public function actionIndex(){
        $models=Address::find()->all();
        return $this->render('address',['models'=>$models]);
    }
    //修改收货地址
    public function actionEdit($id){
        $model=Address::findOne($id);
        $models=Address::find()->all();
//        var_dump($model);exit;
        if($model->load(\Yii::$app->request->post(),'')&& $model->validate()){
            $model->save();
            echo '修改成功';exit;
        }
        return $this->render('address',['model_one'=>$model,'models'=>$models]);
    }
    //删除
    public function actionDel($id){

        $model=Address::findOne($id)->delete();
        echo '删除成功';exit;
    }
}
