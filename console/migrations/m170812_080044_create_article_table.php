<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170812_080044_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
//            name	varchar(50)	名称
            'name'=>$this->string(50)->notNull()->comment('名称'),
//            intro	text	简介
            'intro'=>$this->text()->notNull()->comment('简介'),
            //article_category_id	int()	文章分类id
            'article_category_id'=>$this->integer()->notNull()->comment('文章分類ID'),
            //sort	int(11)	排序
            'sort'=>$this->integer()->notNull()->comment('排序'),
            //status	int(2)	状态(-1删除 0隐藏 1正常)
            'status'=>$this->smallInteger(2)->comment('状态'),
            //create_time	int(11)	创建时间
            'create_time'=>$this->integer()->notNull()->comment('創建時間'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
