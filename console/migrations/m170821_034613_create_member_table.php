<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m170821_034613_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
//            username	varchar(50)	用户名
        'username'=>$this->string(50)->notNull(),
//auth_key	varchar(32)
        'auth_key'=>$this->string(32)->notNull(),
//password_hash	varchar(100)	密码（密文）
        'password_hash'=>$this->string(100)->notNull(),
//email	varchar(100)	邮箱
            'email'=>$this->string(100)->notNull(),
//tel	char(11)	电话
            'tel'=>$this->char(11)->notNull(),
//last_login_time	int	最后登录时间
            'last_login_time'=>$this->integer()->notNull(),
//last_login_ip	int	最后登录ip
            'last_login_ip'=>$this->integer()->notNull(),
//status	int(1)	状态（1正常，0删除）
            'status'=>$this->integer()->notNull(),
//created_at	int	添加时间
            'created_at'=>$this->integer()->notNull(),
//updated_at	int	修改时间
            'updated_at'=>$this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
