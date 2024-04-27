<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_ext".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $unconfirmed_email
 * @property string|null $email
 * @property string|null $email_confirm_token
 * @property int $email_is_verified
 * @property int|null $email_verified_at
 * @property int $rules_accepted
 *
 * @property User $user
 */
class UserExt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_ext';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'email_is_verified', 'email_verified_at', 'rules_accepted'], 'integer'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 25],
            [['unconfirmed_email', 'email', 'email_confirm_token'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'unconfirmed_email' => 'Unconfirmed Email',
            'email' => 'Email',
            'email_confirm_token' => 'Email Confirm Token',
            'email_is_verified' => 'Email Is Verified',
            'email_verified_at' => 'Email Verified At',
            'rules_accepted' => 'Rules Accepted',
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
