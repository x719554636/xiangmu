<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $name
 * @property string $four
 * @property string $distri
 * @property string $xian
 * @property string $addr
 * @property string $tel
 * @property integer $aefault
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'four', 'distri', 'xian', 'addr', 'tel',], 'required'],
            [['aefault'], 'integer'],
            [['name', 'four', 'distri', 'xian'], 'string', 'max' => 50],
            [['addr'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
            [ ['aefault','member_id'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '收件人',
            'four' => '市',
            'distri' => '区',
            'xian' => '县',
            'addr' => '详细地址',
            'tel' => '电话',
            'aefault' => '默认',
        ];
    }
}
