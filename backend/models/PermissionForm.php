<?php
/**
 * Created by PhpStorm.
 * User: kt
 * Date: 2017/8/18
 * Time: 14:16
 */

namespace backend\models;


use yii\base\Model;

class PermissionForm extends  Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name','description'],'required'],
        ];
    }

    public function save(){
        //实例化rbac
        $authManager=\Yii::$app->authManager;
        //判断是否权限已经存在
        if($authManager->getPermission($this->name)){
            $this->addError('name','权限已经存在');
            return false;
        }
        //添加权限
        $permission=$authManager->createPermission($this->name);
        $permission->description=$this->description;
        //保存
        $authManager->add($permission);
        return true;
    }
    //修改方法
    public function update($name){
        //实例化rbac
        $authManager=\Yii::$app->authManager;
        //判断是否权限已经存在
        if($authManager->getPermission($this->name)){
            $this->addError('name','权限已经存在');
            return false;
        }
        //修改权限
        $permission=$authManager->getPermission($name);
        $permission->name=$this->name;
        $permission->description=$this->description;
        //保存
        $authManager->update($name,$permission);
        return true;
    }
    //权限删除方法
    public function delete($name){
        //实例化rbac
        $authManager=\Yii::$app->authManager;
        $permission=$authManager->getPermission($name);
        $authManager->remove($permission);
        return true;
    }




    public function attributeLabels()
    {
        return [
          'name'=>'名称（路由）',
          'description'=>'描述',
        ];
    }
}