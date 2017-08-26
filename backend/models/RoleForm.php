<?php
/**
 * Created by PhpStorm.
 * User: kt
 * Date: 2017/8/18
 * Time: 14:16
 */

namespace backend\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;

class RoleForm extends  Model
{
    public $name;
    public $description;
    public $permissions;

    public function rules()
    {
        return [
            [['name','description'],'required'],
            ['permissions','safe']
        ];
    }
    // 角色添加
    public function save(){

        $authManager = \Yii::$app->authManager;
        if($authManager->getRole($this->name)){
            $this->addError('name','角色已存在');
            return false;
        }else{
            $role = $authManager->createRole($this->name);
            $role->description = $this->description;
            $authManager->add($role);
            //角色关联权限
            if(is_array($this->permissions)){
                foreach ($this->permissions as $permissionName){
                    $permission = $authManager->getPermission($permissionName);
                    $authManager->addChild($role,$permission);//角色，权限
                }
            }
            return true;
        }

    }

    //修改方法
    public function update($name){
        //实例化rbac
        $authManager=\Yii::$app->authManager;
        //修改角色
        $role=$authManager->getRole($name);
        $role->name=$this->name;
        $role->description=$this->description;
        //保存
        $authManager->update($name,$role);

        if(is_array($this->permissions)){
            $authManager->removeChildren($role);
            foreach ($this->permissions as $permissionName){
                $permission = $authManager->getPermission($permissionName);
                $authManager->addChild($role,$permission);//角色，权限
            }
        }else{
            $authManager->removeChildren($role);
        }

        return true;
    }
    //  删除
    public function delete($name){
        //实例化rbac
        $authManager=\Yii::$app->authManager;
        $role=$authManager->getRole($name);
        $authManager->remove($role);
    }



    public function attributeLabels()
    {
        return [
          'name'=>'角色名称',
          'description'=>'描述',
            'permissions'=>'权限'
        ];
    }

    public static function getPermissionItems()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getPermissions(),'name','description');
    }

}