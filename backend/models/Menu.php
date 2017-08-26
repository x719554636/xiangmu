<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $label
 * @property integer $parent_id
 * @property string $url
 * @property integer $sort
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'parent_id',  'sort'], 'required'],
            [['parent_id', 'sort'], 'integer'],
            ['url','safe'],
            [['label', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => '名稱',
            'parent_id' => 'Parent ID',
            'url' => '路由',
            'sort' => '排序',
        ];
    }

    public static function getPermission()
    {
        return ArrayHelper::merge(
            [''=>'请选择路由地址'],
            ArrayHelper::map(Yii::$app->authManager->getPermissions(),'name','name')
        );
    }

    public static function getMenu()
    {
        return ArrayHelper::merge(
            [0=>'顶级菜单'],
            ArrayHelper::map(Menu::find()->all(),'id','label')
        );
    }


}
