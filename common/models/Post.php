<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Post".
 *
 * @property int $user_id
 * @property string|null $title
 * @property string|null $text
 * @property int $post_category_id
 * @property int|null $status
 * @property string|null $image
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property PostCategory $postCategory
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['post_category_id'], 'required'],
            [['post_category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['post_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostCategory::class, 'targetAttribute' => ['post_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app','Title'),
            'text' => Yii::t('app','Text'),
            'post_category_id' => Yii::t('app','Post Category ID'),
            'status' => Yii::t('app','Status'),
            'image' => Yii::t('app','Image'),
            'created_at' => Yii::t('app','Created At'),
            'updated_at' => Yii::t('app','Updated At'),
        ];
    }

    /**
     * Gets query for [[PostCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostCategory()
    {
        return $this->hasOne(PostCategory::class, ['id' => 'post_category_id']);
    }
}
