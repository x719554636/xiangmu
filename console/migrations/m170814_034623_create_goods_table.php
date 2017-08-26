<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170814_034623_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
//            name	varchar(20)	商品名称
        'name'=>$this->string(20),
//sn	varchar(20)	货号
        'sn'=>$this->string(20),
//logo	varchar(255)	LOGO图片
        'logo'=>$this->string(255),
//goods_category_id	int	商品分类id
        'goods_category_id'=>$this->integer(),
//brand_id	int	品牌分类
        'brand_id'=>$this->integer(),
//market_price	decimal(10,2)	市场价格
        'market_price'=>$this->decimal(10,2),
//shop_price	decimal(10, 2)	商品价格
        'shop_price'=>$this->decimal(10,2),
//stock	int	库存
        'stock'=>$this->integer(),
//is_on_sale	int(1)	是否在售(1在售 0下架)
        'is_on_sale'=>$this->integer(),
//status	inter(1)	状态(1正常 0回收站)
        'status'=>$this->integer(),
//sort	int()	排序
            'sort'=>$this->integer(),
//create_time	int()	添加时间
            'create_time'=>$this->integer(),
//view_times	int()	浏览次数
            'view_times'=>$this->integer(),
        ]);
        $this->createTable('goods_day_count', [
//            day	date	日期
        'day'=>$this->date(),
//count	int	商品数
            'count'=>$this->integer(),
        ]);
        $this->addPrimaryKey('day','goods_day_count','day');


        $this->createTable('goods_intro', [
//            goods_id	int	商品id
            'goods_id'=>$this->integer(),
//content	text	商品描述
            'content'=>$this->text(),

        ]);
        $this->createTable('goods_gallery', [
            'id' => $this->primaryKey(),
//            goods_id	int	商品id
            'goods_id'=>$this->integer(),
//path	varchar(255)	图片地址
            'path'=>$this->string(255),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
        $this->dropTable('goods_day_count');
        $this->dropTable('goods_intro');
        $this->dropTable('goods_gallery');
    }
}
