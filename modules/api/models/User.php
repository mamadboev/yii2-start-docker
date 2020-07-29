<?php

namespace app\modules\api\models;

use Yii;
use Yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password_hash
 * @property string|null $auth_token
 *
 * @property Post[] $posts
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'auth_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_token' => 'Auth Token',
        ];
    }

    /**
     * @throws Exception
     */
    public function generateAuthToken(): void
    {
        $this->auth_token = Yii::$app->security->generateRandomString();
    }


    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id): ?self
    {
       return self::findOne(['id' => $id ]);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
      return static::find()
          ->where(['auth_token' => $token])
          ->one();
    }

    /**
     * @return int|mixed|string
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_token;
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_token === $authKey;
    }
}
