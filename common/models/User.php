<?php

namespace common\models;

use common\helpers\StringHelper;
use Yii;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $uid
 * @property string $name
 * @property string $password
 * @property string $mail
 * @property string $url
 * @property string $screenName
 * @property integer $created
 * @property integer $activated
 * @property integer $logged
 * @property string $group
 * @property string $authCode
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const GROUP_VISITOR='visitor';
    const GROUP_SUBSCRIBER='subscriber';
    const GROUP_CONTRIBUTOR='contributor';
    const GROUP_EDITOR='editor';
    const GROUP_ADMINISTRATOR='administrator';

    public static function getUserGroup(){
        return [
            self::GROUP_ADMINISTRATOR=>'管理员',
            self::GROUP_CONTRIBUTOR=>'贡献者',
            self::GROUP_EDITOR=>'编辑',
            self::GROUP_SUBSCRIBER=>'关注者',
            self::GROUP_VISITOR=>'访问者',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','mail','password'],'required','on'=>['create']],
            [['mail'],'required','on'=>['update','profile']],
            [['password'], 'string', 'min' => 6,'max'=>20],
            [['name'], 'string', 'max' => 32,'on'=>['create']],
            [['screenName'], 'string', 'max' => 32],
            [['name'], 'checkName','on'=>['create']],
            [['screenName'], 'checkName', 'skipOnEmpty'=>false],
            [['mail'],'email'],
            [['url'],'url'],
            [['mail', 'url'], 'string', 'max' => 200],
            [['name'], 'unique','on'=>['create']],
            [['mail','screenName'], 'unique'],
            [['group'],'filter','filter'=>function($value){
                if(!array_key_exists($value,self::getUserGroup())){
                    return self::GROUP_VISITOR;
                }
                return $value;
            },'on'=>['create','update']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'name' => '用户名',
            'password' => '密码',
            'mail' => '邮箱',
            'url' => '个人主页',
            'screenName' => '昵称',
            'created' => '创建时间',
            'activated' => '活跃时间',
            'logged' => '登录时间',
            'group' => '用户组',
            'authCode' => 'Auth Code',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['uid' => $id,]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authCode;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function generatePassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authCode = Yii::$app->security->generateRandomString();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['name' => $username]);
    }

    public function checkName($attribute, $params){

        if (!$this->hasErrors()) {
            if(($attribute=='name')||($attribute=='screenName'&&$this->$attribute!='')){
                if(!StringHelper::checkCleanStr($this->$attribute)){
                    $this->addError($attribute, $this->getAttributeLabel($attribute).'只能为数字字母下划线横线');
                }
            }

        }
    }

    public function beforeSave($insert){

        if(parent::beforeSave($insert)){
            if($this->scenario=='create'){
                $this->generatePassword($this->password);
            }elseif($this->scenario=='update'||$this->scenario='profile'){
                if(trim($this->password)==''){
                    $this->password= $this->getOldAttribute('password');
                }else{
                    $this->generatePassword($this->password);
                }
            }
            if($insert){
                $this->created=time();
                $this->generateAuthKey();
            }
            if(trim($this->screenName)==''){
                $this->screenName=$this->name;
            }

            return true;
        }else{
            return false;
        }
    }

    public function getPosts($isPublished=true){
        $query=$this->hasMany(Post::className(),['authorId'=>'uid'])->with('categories')->with('tags')->with('author')->orderByCid();
        if($isPublished){
            return $query->published();
        }
        return $query;

    }
}
