<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170813_072402_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
//            tree	int()	树id
            'tree'=>$this->integer(),
//lft	int()	左值
        'lft'=>$this->integer(),
//rgt	int()	右值
            'rgt'=>$this->integer(),
//depth	int()	层级
            'depth'=>$this->integer(),
//name	varchar(50)	名称
            'name'=>$this->string(50),
//parent_id	int()	上级分类id
            'parent_id'=>$this->integer(),
//intro	text()	简介
            'intro'=>$this->text(),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
