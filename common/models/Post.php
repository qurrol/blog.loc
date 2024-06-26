<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
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
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['text'], 'string'],
            [['post_category_id'], 'required'],
            [['post_category_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['post_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PostCategory::class, 'targetAttribute' => ['post_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'post_category_id' => Yii::t('app', 'Post Category ID'),
            'status' => Yii::t('app', 'Status'),
            'image' => Yii::t('app', 'Image'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function beforeValidate(): bool
    {
        if (empty($this->imageFile)) {
            $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        }
        return parent::beforeValidate();
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $uploads = Yii::getAlias('@uploads');
            if (!$insert && !empty($this->image)) {
                $oldImagePath = $uploads . '/' . $this->getOldAttribute('image');
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            if ($this->imageFile) {
                $filename = Yii::$app->security->generateRandomString();
                $extension = $this->imageFile->extension;
                $this->image = $filename . '.' . $extension; // <- путь до файла

                $this->imageFile->saveAs($uploads . '/' . $filename . '.' . $extension);
                return parent::beforeSave($insert);
            }
            return true;
        }
        return false;
    }

    public function afterDelete()
    {
        $uploads = Yii::getAlias('@uploads');

        if (!empty($this->image)) {
            $path = $uploads . '/' . $this->image;

            if (file_exists($path)) {
                unlink($path);
            }
        }
        parent::afterDelete();
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'user_id',
            'title',
            'text',
            'post_category' => fn() => $this->postCategory->name,
            'image' => fn() => $this->image ? (Yii::$app->request->hostInfo . '/uploads/' . $this->image) : null,
        ];
    }

}
