<?php

namespace backend\controllers;

use backend\models\PermissionForm;
use backend\models\RoleForm;
use yii\rbac\Role;

class RbacController extends \yii\web\Controller
{
    //权限列表
    public function actionPermissionIndex(){
        //获取所有权限
        $permissions = \Yii::$app->authManager->getPermissions();

        return $this->render('permission-index',['permissions'=>$permissions]);
    }


    //权限添加
    public function actionPermission(){
        $model= new PermissionForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->save()){
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['permission-index']);
            }
        }
        return $this->render('permission',['model'=>$model]);
    }

    //权限修改
    public function actionPermissionEdit($name){
        $model= new PermissionForm();
        $authManager = \Yii::$app->authManager;
        $permission=$authManager->getPermission($name);
        $model->name=$permission->name;
        $model->description=$permission->description;
//        var_dump($name);exit;
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->update($name)){
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['permission-index']);
            }
        }
        return $this->render('permission',['model'=>$model]);
    }
    //权限删除
    public function actionPermissionDel($name){
        $model=new PermissionForm();
        $model->delete($name);
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect(['permission-index']);

    }


    //角色列表
    public function actionRoleIndex(){
        //获取所有权限
        $role = \Yii::$app->authManager->getRoles();
        return $this->render('role-index',['roles'=>$role]);
    }

    //角色添加
    public function actionRole(){
        $model= new RoleForm();
//
        if($model->load(\Yii::$app->request->post())&& $model->validate()){
//            var_dump($model);exit;
            if($model->save()){
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['role-index']);
            }
        }
        return $this->render('role',['model'=>$model]);
    }

    //角色修改
    public function actionRoleEdit($name){
        $model= new RoleForm();
        $authManager = \Yii::$app->authManager;
        $role=$authManager->getRole($name);
        $permission=$authManager->getPermissionsByRole($name);
        $model->name=$role->name;
        $model->description=$role->description;
        $permission_array=array_keys($permission);
        $model->permissions=$permission_array;
//        var_dump($permission);exit;

        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            if($model->update($name)){
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['role-index']);
            }
        }
        return $this->render('role',['model'=>$model]);
    }
    //角色删除
    public function actionRoleDel($name){
        $model=new RoleForm();
        $model->delete($name);
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['role-index']);

    }

}
