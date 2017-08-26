<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170820_031006_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'label'=>$this->string()->notNull()->comment('名稱'),
            'parent_id'=>$this->integer()->notNull(),
            'url'=>$this->string()->notNull()->comment('路由'),
            'sort'=>$this->integer()->notNull()->comment('排序'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
