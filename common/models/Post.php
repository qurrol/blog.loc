<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

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
     * @var UploadedFile
     */
    public $imageFile;

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
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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

    const status_brandnew = 10;
    const status_published = 20;
    const status_rejected = 30;

    public static function getStatusOptions()
    {
        return [
            self::status_brandnew => 'Новый',
            self::status_published => 'Опубликовано',
            self::status_rejected => 'Отклоненный',
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

    public function beforeValidate(): bool
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        return parent::beforeValidate();
    }

    public function beforeSave($insert): bool
    {
        $uploads = Yii::getAlias('@uploads');
        if (!$insert && !empty($this->image)) {
            $oldImagePath = $uploads . '/' . $this->getOldAttribute('image');
            if(file_exists($oldImagePath)){
                unlink($oldImagePath);
            }
        }

        $filename = Yii::$app->security->generateRandomString();
        $extension = $this->imageFile->extension;
        $this->image =  $filename . '.' . $extension; // <- путь до файла

        $this->imageFile->saveAs($uploads . '/' . $filename . '.' . $extension);
        return parent::beforeSave($insert);
    }

    public function afterDelete()
    {
        $uploads = Yii::getAlias('@uploads');

        $imagePath = $this->image;
        $path = $uploads . '/' . $imagePath;

        if (file_exists($path)) {
            unlink($path);
        }
        parent::afterDelete();
    }

}
