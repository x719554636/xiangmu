<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property string $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{
//    public $imgFlie;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'intro','logo', 'sort'], 'required'],
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
//            [['name', 'logo'], 'string', 'max' => 255],
//            ['imgFlie','file','extensions'=>['jpg','png','gif'],'skipOnEmpty'=>true],
        ];

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
            'intro' => '商品简介',
            'sort' => '排序',
            'status' => '状态',
            'imgFlie'=>'商品图片',
        ];
    }
}
