<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password_hash
 * @property string|null $auth_source
 * @property string|null $auth_key
 * @property string|null $password_reset_token
 * @property int|null $last_login_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 *
 * @property SocialNetwork[] $socialNetworks
 * @property UserExt[] $userExts
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_login_at', 'created_at', 'updated_at', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'required'],
            [['username', 'auth_source', 'auth_key', 'password_reset_token'], 'string', 'max' => 255],
            [['password_hash'], 'string', 'max' => 60],
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
            'auth_source' => 'Auth Source',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'last_login_at' => 'Last Login At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[SocialNetworks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocialNetworks()
    {
        return $this->hasMany(SocialNetwork::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserExts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserExts()
    {
        return $this->hasMany(UserExt::class, ['user_id' => 'id']);
    }
}
