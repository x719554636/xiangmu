<?php

use yii\db\Migration;

/**
 * Handles the creation of table `adimin`.
 */
class m170816_032116_create_adimin_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('adimin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(255)->notNull()->comment('用戶名'),
            'auth_key'=>$this->string(255)->notNull()->comment('验证码'),
            'password_hash'=>$this->string(255)->notNull()->comment('密码'),
            'password_reset_token'=>$this->string(255)->notNull()->comment('重置密码'),
            'email'=>$this->string(255)->notNull()->comment('邮箱'),
            'status'=>$this->smallInteger()->notNull()->comment('删除'),
            'created_at'=>$this->integer()->notNull()->comment('创建时间'),
            'updated_at'=>$this->integer()->notNull()->comment('更新时间'),
            'last_login_time'=>$this->integer()->notNull()->comment('最后登录的时间'),
            'last_login_ip'=>$this->integer()->notNull()->comment('最后登录的IP'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('adimin');
    }
}
