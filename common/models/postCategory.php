<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "postCategory".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Post[] $posts
 */
class postCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'postCategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','ID'),
            'name' => Yii::t('app','Name'),
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['post_category_id' => 'id']);
    }
}
