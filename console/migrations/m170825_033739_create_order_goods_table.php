<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_goods`.
 */
class m170825_033739_create_order_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_goods', [
            'id' => $this->primaryKey(),
//            order_id	int	订单id
            'order_id'=>$this->integer()->notNull(),
//            goods_id	int	商品id
            'goods_id'=>$this->integer()->notNull(),
//            goods_name	varchar(255)	商品名称
            'goods_name'=>$this->string(255)->notNull(),
//            logo	varchar(255)	图片
            'logo'=>$this->string(255)->notNull(),
//            price	decimal	价格
            'price'=>$this->decimal()->notNull(),
//            amount	int	数量
            'amount'=>$this->integer()->notNull(),
//            total	decimal	小计
            'total'=>$this->decimal()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_goods');
    }
}
