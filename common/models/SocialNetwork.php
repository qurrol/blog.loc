<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "social_network".
 *
 * @property int $id
 * @property int $user_id
 * @property string $social_network_id
 * @property string $user_auth_id
 * @property string|null $access_token
 * @property int|null $last_auth_date
 *
 * @property User $user
 */
class SocialNetwork extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'social_network';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'social_network_id', 'user_auth_id'], 'required'],
            [['user_id', 'last_auth_date'], 'integer'],
            [['social_network_id'], 'string', 'max' => 10],
            [['user_auth_id', 'access_token'], 'string', 'max' => 300],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'user_id' => Yii::t('app','User ID'),
            'social_network_id' => Yii::t('app','Social Network ID'),
            'user_auth_id' => Yii::t('app','User Auth ID'),
            'access_token' => Yii::t('app','Access Token'),
            'last_auth_date' => Yii::t('app','Last Auth Date'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
