<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170821_084425_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('收件人'),
            'four'=>$this->string(50)->notNull()->comment('市'),
            'distri'=>$this->string(50)->notNull()->comment('区'),
            'xian'=>$this->string(50)->notNull()->comment('县'),
            'addr'=>$this->string(100)->notNull()->comment('详细地址'),
            'tel'=>$this->char()->notNull()->comment('电话'),
            'aefault'=>$this->integer()->notNull()->comment('默认'),
            'member_id'=>$this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
