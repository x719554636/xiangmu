<?php
namespace backend\filters;
use yii\base\ActionFilter;
use yii\web\HttpException;

class RbacFilters extends ActionFilter
{
        public function beforeAction($action)
    {
        //$action->uniqueId;//当前访问的路由 admin/add
        if(!\Yii::$app->user->can($action->uniqueId)){
            //如果用户没有登陆，则引导用户到登陆页面
            if(\Yii::$app->user->isGuest){
                //一定不要忘记加send()方法
                return $action->controller->redirect(\Yii::$app->user->loginUrl)->send();
            }
            //没有该执行权限，抛出403状态码
            throw new HttpException(403,'对不起，您没有该执行权限');

        }
        //拦截 禁止访问
        //return false;//禁止
        //return true;//放行
        return parent::beforeAction($action);
    }

}