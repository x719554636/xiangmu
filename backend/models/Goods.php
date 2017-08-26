<?php

namespace backend\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property string $market_price
 * @property string $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $create_time
 * @property integer $view_times
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_category_id', 'brand_id', 'stock', 'is_on_sale', 'status', 'sort', 'create_time', ], 'integer'],
            [['market_price', 'shop_price'], 'number'],
            [['name', 'sn'], 'string', 'max' => 20],
            [['logo'], 'string', 'max' => 255],
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
            'sn' => '货号',
            'logo' => '图片',
            'goods_category_id' => '商品分类',
            'brand_id' => '品牌分类',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => 'Is On Sale',
            'status' => 'Status',
            'sort' => '排序',
            'create_time' => 'Create Time',
            'view_times' => '浏览次数',
        ];
    }

    //获取商品分类选项
    public static function getGoodsItems()
    {
        $models =Brand::find()->all();
        $items = [];
        foreach ($models as $model){
            $items[$model->id] = $model->name;
        }
        return $items;
    }

    //获取商品分类选项
    public static function getCategoryItems()
    {
        $models = GoodsCategory::find()->all();
        $items = [0=>'顶级分类'];
        foreach ($models as $model){
            $items[$model->id] = $model->name;
        }

        return $items;
    }
    //获取商品分类ztree数据
    public static function getZNodes()
    {
        return Json::encode(
            ArrayHelper::merge(
                [['id'=>0,'parent_id'=>0,'name'=>'顶级分类']],
                self::find()->select(['id','name','parent_id'])->asArray()->all()
            )
        );
    }

}
