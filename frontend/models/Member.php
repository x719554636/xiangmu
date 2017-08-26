<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;
    public $repassword;
    public $code;
    //定义常量场景
    const SCENARIO_ADD = 'add';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username',  'password',], 'required'],
            [['last_login_time', 'last_login_ip', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'email'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
            [['username'],'unique' ,'on'=>'user/regist'],
            [['email'],'email'],
            [['email'],'unique'],
            [['auth_key','tel','repassword',],'safe'],
            ['code', 'captcha','captchaAction'=>'user/captcha','on'=>[self::SCENARIO_ADD],],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'tel' => 'Tel',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    //登录
    public function login(){
        $userObj=Yii::$app->user;
        //接收用户名
        $usename = $this->username;
        $password=$this->password;
        $auth_key=$this->auth_key;
//        var_dump($password);exit;
        if($auth_key){
            $auth_key=7*24*3600;
        }
        $loginInfo=Member::findOne(['username'=>$usename]);

        //判断是否有用户
        if(empty($loginInfo)){
            echo '没有该用户';
            return false;
        }
        //密码加密
        if(!\Yii::$app->security->validatePassword($password,$loginInfo->password_hash)){
            echo '密码错误';
            return false;
        }
        if($userObj->login($loginInfo,$auth_key)){
            $loginInfo->last_login_time=time();
            $loginInfo->last_login_ip=ip2long(\Yii::$app->request->userIP);
            $loginInfo->save(false);
            return true;
        }
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
        // TODO: Implement getId() method.
    }

    public function getAuthKey()
    {
        return $this->auth_key;
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        return $authKey===$this->getAuthKey();
        // TODO: Implement validateAuthKey() method.
    }


}
